import { HttpRequest } from '../services/httpRequest.js';
import { dataTableConfig, l10n } from '../config/app-config.js';
import { CacheManager } from '../cache/cache.js';

/**
 * DynamicContentManager - A class for managing dynamic content loading with filtering, caching and pagination
 *
 * @class
 * @description Handles dynamic content loading with support for filtering, caching, pagination and customizable loading states
 *
 * @param {Object} options - Configuration options
 * @param {(string|Element)} options.contentSection - Target element where content will be loaded (required)
 * @param {string} options.route - API endpoint route for fetching data (required)
 * @param {(string|Element)} [options.filterForm] - Form element containing filter inputs
 * @param {(string|Element)} [options.searchBtn] - Search/submit button element
 * @param {(string|Element)} [options.clearFilterBtn] - Clear filters button element
 * @param {Object} [options.cacheOptions] - Caching configuration
 * @param {boolean} [options.cacheOptions.enabled=false] - Enable/disable caching
 * @param {number} [options.cacheOptions.maxAge=600000] - Cache entry max age in ms (default 10 mins)
 * @param {number} [options.cacheOptions.maxEntries=10] - Maximum number of cache entries
 * @param {Object} [options.callbacks] - Callback functions
 * @param {Function} [options.callbacks.onSuccess] - Called after successful data fetch
 * @param {Function} [options.callbacks.onLoading] - Called when loading starts
 * @param {Function} [options.callbacks.onError] - Called when an error occurs
 * @param {Function} [options.callbacks.onCacheHit] - Called when data is retrieved from cache
 * @param {Object} [options.config] - Additional configuration
 * @param {boolean} [options.config.toggleSubmitButtonOnFormInput=false] - Toggle button state based on form validity
 * @param {string} [options.config.loadingSpinner] - Custom loading spinner HTML
 * @param {number} [options.config.debounceDelay=300] - Debounce delay for fetch requests in ms
 * @param {boolean} [options.config.autoAttachPagination=true] - Auto attach pagination event listeners
 * @param {Object} [options.axios] - Custom axios instance
 * @param {boolean} [options.config.updateURL=true] - Update URL with query parameters
 * @param {string} [options.config.queryParam='page'] - Query parameter name for page number
 *
 * @example
 * const manager = new DynamicContentManager({
 *   contentSection: '#content',
 *   route: '/api/data',
 *   filterForm: '#filterForm', // optional
 *   searchBtn: '#searchButton', // optional
 *   clearFilterBtn: '#clearButton', // optional
 *   toggleSubmitButtonOnFormInput: true, // optional (default: false, prevents button from being disabled when form is empty)
 *   cacheOptions: {
 *     enabled: true,
 *     maxAge: 300000,
 *     maxEntries: 5
 *   },
 *   callbacks: {
 *     onSuccess: (data, filterForm, searchBtn, clearFilterBtn, contentSection) => console.log('Data loaded:', data),
 *     onError: (error, filterForm, searchBtn, clearFilterBtn, contentSection) => console.error('Error:', error)
 *   },
 *   config: {
 *     toggleSubmitButtonOnFormInput: true,
 *     debounceDelay: 500
 *   }
 * });
 */
export class DynamicContentManager {
    constructor(configs = []) {
        // Validate configs is an array
        if (!Array.isArray(configs)) {
            configs = [configs];
        }

        this.managers = configs.map(config => {
            return {
                // Required options
                contentSection: this._validateElement(config.contentSection, 'Content section'),
                route: this._validateRoute(config.route),

                // Filter form options
                filterForm: config.filterForm ? this._validateElement(config.filterForm, 'Filter form') : null,
                searchBtn: config.searchBtn ? this._validateElement(config.searchBtn, 'Search button') : null,
                clearFilterBtn: config.clearFilterBtn ? this._validateElement(config.clearFilterBtn, 'Clear filter button') : null,

                // Cache manager for this instance
                cacheManager: new CacheManager({
                    maxEntries: config.cacheOptions?.maxEntries || 10,
                    maxAge: config.cacheOptions?.maxAge || 10 * 60 * 1000
                }),

                // Cache enabled flag
                cacheEnabled: config.cacheOptions?.enabled || false,

                // Callbacks
                callbacks: {
                    onSuccess: config.callbacks?.onSuccess || (() => { }),
                    onLoading: config.callbacks?.onLoading || (() => { }),
                    onError: config.callbacks?.onError || (() => { }),
                    onCacheHit: config.callbacks?.onCacheHit || (() => { })
                },

                // Configuration options
                config: {
                    toggleSubmitButtonOnFormInput: config.toggleSubmitButtonOnFormInput || false,
                    loadingSpinner: config.loadingSpinner || this._defaultLoadingSpinner(),
                    debounceDelay: config.debounceDelay || 300,
                    autoAttachPagination: config.autoAttachPagination !== false,
                    updateURL: config.updateURL !== false,
                    queryParam: config.queryParam || 'page',
                    initialLoad: config.config?.initialLoad,
                    onClearFilters: config.config?.onClearFilters || (() => { })
                },

                // Get initial page from URL
                initialPage: this._getPageFromURL(config.queryParam || 'page')
            };
        });

        // Axios instance (shared across all managers)
        this.axios = configs[0]?.axios || window.axios;
        if (!this.axios) {
            throw new Error('Axios is required. Please provide axios in options or ensure it is globally available.');
        }

        // Add this method to the class
        this.toggleSubmitButtonOnFormInput = (manager) => {
            if (!manager.filterForm || !manager.searchBtn) {
                return;
            }

            const formElements = manager.filterForm.querySelectorAll('input, textarea, select');
            let hasValue = false;

            formElements.forEach(element => {
                element.addEventListener('input', () => {
                    hasValue = false;

                    formElements.forEach(el => {
                        if (el.type === 'checkbox') {
                            if (el.checked) {
                                hasValue = true;
                            }
                        } else {
                            if (el.value.trim() !== '') {
                                hasValue = true;
                            }
                        }
                    });

                    manager.searchBtn.classList.toggle('disabled', !hasValue);
                });
            });

            // Initial state check
            formElements.forEach(el => {
                if (el.type === 'checkbox') {
                    if (el.checked) {
                        hasValue = true;
                    }
                } else {
                    if (el.value.trim() !== '') {
                        hasValue = true;
                    }
                }
            });
            manager.searchBtn.classList.toggle('disabled', !hasValue);
        };

        // Initialize all managers
        this.init();
    }

    _validateElement(element, name) {
        if (typeof element === 'string') {
            element = document.querySelector(element);
        }
        if (!element || !(element instanceof Element)) {
            throw new Error(`${name} element is invalid or not found`);
        }
        return element;
    }

    _validateRoute(route) {
        if (!route || typeof route !== 'string') {
            throw new Error('A valid API route is required');
        }
        return route;
    }

    _defaultLoadingSpinner() {
        return `
            <div class="d-flex justify-content-center align-items-center">
                <div class="spinner-border text-primary" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
            </div>
        `;
    }

    _debounce(func, delay) {
        let timeoutId;
        return function (...args) {
            const context = this;
            clearTimeout(timeoutId);
            timeoutId = setTimeout(() => func.apply(context, args), delay);
        };
    }

    _getPageFromURL(queryParam) {
        const urlParams = new URLSearchParams(window.location.search);
        return parseInt(urlParams.get(queryParam)) || 1;
    }

    _updateURL(page, filters = {}, queryParam) {
        if (!this.managers[0].config.updateURL) return;

        const url = new URL(window.location.href);

        // Update page parameter
        if (page === 1) {
            url.searchParams.delete(this.managers[0].config.queryParam);
        } else {
            url.searchParams.set(this.managers[0].config.queryParam, page);
        }

        // Update filter parameters
        Object.entries(filters).forEach(([key, value]) => {
            if (value) {
                url.searchParams.set(key, value);
            } else {
                url.searchParams.delete(key);
            }
        });

        window.history.pushState({}, '', url);
    }

    init() {
        this.managers.forEach(manager => {
            this.setupEventListeners(manager);

            // Only load initial data if initialLoad is true
            if (manager.config.initialLoad === true) {
                console.log('Loading initial data for manager:', manager.filterForm?.id);
                this.loadInitialData(manager);
            }

            if (manager.filterForm && manager.clearFilterBtn) {
                this.toggleClearButton(manager);
            }
        });

        // Handle browser back/forward buttons
        window.addEventListener('popstate', () => {
            // Only handle popstate for the manager with initialLoad true
            const primaryManager = this.managers.find(m => m.config.initialLoad === true);
            if (primaryManager) {
                const page = this._getPageFromURL(primaryManager.config.queryParam);
                this.fetchData(primaryManager, page, false);
            }
        });
    }

    setupEventListeners(manager) {
        if (manager.filterForm) {
            // Form submit event
            manager.filterForm.addEventListener('submit', async (e) => {
                e.preventDefault();
                await this.fetchData(manager, 1, true);
            });

            // Search button click
            if (manager.searchBtn) {
                manager.searchBtn.addEventListener('click', async (e) => {
                    e.preventDefault(); // Prevent form submission
                    await this.fetchData(manager, 1, true);
                });
            }

            // Clear filters button
            if (manager.clearFilterBtn) {
                manager.clearFilterBtn.addEventListener('click', async (e) => {
                    e.preventDefault(); // Prevent any form submission
                    e.stopPropagation(); // Stop event bubbling

                    // Reset the form without triggering events
                    const formElements = manager.filterForm.querySelectorAll('input, select');
                    formElements.forEach(element => {
                        if (element.type === 'checkbox') {
                            element.checked = false;
                        } else {
                            element.value = '';
                        }
                    });

                    // Clear URL parameters
                    window.history.pushState({}, '', window.location.pathname);

                    // Call the onClearFilters callback if it exists
                    if (manager.config.onClearFilters) {
                        manager.config.onClearFilters();
                    }

                    if (manager.config.toggleSubmitButtonOnFormInput) {
                        this.toggleSubmitButtonOnFormInput(manager);
                    }

                    // Check for cached default state
                    const defaultCacheKey = 'default_state';
                    if (manager.cacheEnabled) {
                        const cachedData = manager.cacheManager.get(defaultCacheKey);
                        if (cachedData) {
                            manager.contentSection.innerHTML = cachedData.html;
                            manager.callbacks.onCacheHit(cachedData);
                            this.toggleClearButton(manager);
                            return;
                        }
                    }

                    // If no cache, fetch and cache the default state
                    const response = await this.fetchData(manager, 1, true);
                    if (response && manager.cacheEnabled) {
                        manager.cacheManager.set(defaultCacheKey, response);
                    }

                    this.toggleClearButton(manager);
                });
            }

            // Input change events for clear button toggle
            if (manager.clearFilterBtn) {
                manager.filterForm.querySelectorAll('input, select').forEach(element => {
                    element.addEventListener('change', () => {
                        this.toggleClearButton(manager);
                    });
                });
            }
        }
    }

    toggleClearButton(manager) {
        if (!manager.clearFilterBtn || !manager.filterForm) return;

        const formElements = manager.filterForm.querySelectorAll('input, select');
        let hasValue = false;

        // Check form elements
        formElements.forEach(element => {
            if (element.type === 'checkbox') {
                if (element.checked) hasValue = true;
            } else {
                if (element.value.trim() !== '') hasValue = true;
            }
        });

        // Also check URL parameters
        const urlParams = new URLSearchParams(window.location.search);
        if (Array.from(urlParams.entries()).length > 0) {
            hasValue = true;
        }

        // Show/hide clear button based on whether there are any values
        manager.clearFilterBtn.style.display = hasValue ? 'inline-flex' : 'none';
    }

    showLoadingSection(manager) {
        // If there's a custom loading callback, use it instead of default loading
        if (manager.callbacks.onLoading !== (() => { })) {
            manager.callbacks.onLoading(manager.contentSection);
            return; // Exit early to prevent default loading spinner
        }

        // Default loading behavior only runs if no custom callback is provided
        manager.contentSection.innerHTML = manager.config.loadingSpinner;
    }

    async fetchData(manager, page = 1, updateURL = true) {
        this.showLoadingSection(manager);

        let params = new URLSearchParams();
        params.append('page', page);

        // Collect filter parameters
        let filters = {};
        if (manager.filterForm) {
            const formData = new FormData(manager.filterForm);
            for (let [key, value] of formData.entries()) {
                if (value) {
                    params.append(key, value);
                    filters[key] = value;
                }
            }
        } else {
            // If no form is present but we have URL parameters, use them
            const urlParams = new URLSearchParams(window.location.search);
            urlParams.forEach((value, key) => {
                if (value) {
                    params.append(key, value);
                    filters[key] = value;
                }
            });
        }

        // Update URL if needed
        if (updateURL) {
            this._updateURL(page, filters, manager.config.queryParam);
        }

        // Check cache
        if (manager.cacheEnabled) {
            const cacheKey = params.toString();
            const cachedData = manager.cacheManager.get(cacheKey);

            if (cachedData) {
                manager.contentSection.innerHTML = cachedData.html;
                manager.callbacks.onCacheHit(cachedData);

                if (manager.config.autoAttachPagination) {
                    this.attachPaginationListeners(manager);
                }

                return;
            }
        }

        try {
            if (manager.searchBtn) {
                manager.searchBtn.disabled = true;
            }

            const response = await this.axios.get(`${manager.route}?${params.toString()}`);

            if (response.status === 200) {
                manager.contentSection.innerHTML = response.data.html;

                if (manager.cacheEnabled) {
                    manager.cacheManager.set(params.toString(), response.data);
                }

                if (manager.config.autoAttachPagination) {
                    this.attachPaginationListeners(manager);
                }

                manager.callbacks.onSuccess(response.data, manager.filterForm, manager.searchBtn, manager.clearFilterBtn, manager.contentSection);
            }

        } catch (error) {
            console.error('Error fetching data:', error);
            manager.contentSection.innerHTML = `
                <div class="alert alert-danger">
                    Error loading content: ${error.message}
                </div>
            `;
            manager.callbacks.onError(error, manager.filterForm, manager.searchBtn, manager.clearFilterBtn, manager.contentSection);
        } finally {
            if (manager.searchBtn) {
                manager.searchBtn.disabled = false;
            }
        }
    }

    attachPaginationListeners(manager) {
        const paginationLinks = manager.contentSection.querySelectorAll('.pagination .page-link');
        paginationLinks.forEach(link => {
            link.addEventListener('click', async (e) => {
                e.preventDefault();
                if (!link.closest('.page-item').classList.contains('disabled')) {
                    const page = link.getAttribute('data-page');
                    await this.fetchData(manager, page, true);
                }
            });
        });
    }

    async loadInitialData(manager) {
        // Get all URL parameters
        const urlParams = new URLSearchParams(window.location.search);
        const hasFilters = Array.from(urlParams.entries()).length > 0;

        if (hasFilters) {
            // If we have URL parameters, use them for the initial fetch
            const formData = new FormData(manager.filterForm);

            // Update form fields based on URL parameters
            urlParams.forEach((value, key) => {
                const formElement = manager.filterForm?.querySelector(`[name="${key}"]`);
                if (formElement) {
                    if (formElement.type === 'checkbox') {
                        formElement.checked = value === 'true';
                    } else {
                        formElement.value = value;
                    }
                }
            });
        }

        // Get the page from URL or default to 1
        const page = this._getPageFromURL(manager.config.queryParam);
        await this.fetchData(manager, page, false);
    }

    clearCache(manager) {
        manager.cacheManager.clear();
    }

    clearAllCaches() {
        this.managers.forEach(manager => manager.cacheManager.clear());
    }
}

export class ModalLoader {
    static defaultLoadingSpinner = `
        <div class="d-flex justify-content-center align-items-center" style="height: 200px">
            <div class="spinner-border text-primary" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
        </div>
    `;

    constructor(config) {
        this.triggerSelector = config.triggerSelector;
        this.modalBodySelector = config.modalBodySelector;
        this.loadingHtml = config.loadingHtml || ModalLoader.defaultLoadingSpinner;
        this.endpoint = config.endpoint;
        this.onSuccess = config.onSuccess;
        this.onError = config.onError;
        this.autoInit = config.autoInit !== false; // Default to true if not specified

        this.modalBody = document.querySelector(this.modalBodySelector);

        // Initialize
        if (this.autoInit) {
            this.init();
        }
    }

    async init() {
        if (!this.modalBody) {
            console.error('Modal body element not found');
            return;
        }

        if (this.triggerSelector) {
            this.trigger = document.querySelector(this.triggerSelector);
            if (this.trigger) {
                this.trigger.addEventListener('click', () => this.handleModalOpen());
            }
        } else {
            // If no trigger is specified, load content immediately
            await this.handleModalOpen();
        }
    }

    async handleModalOpen() {
        try {
            this.showLoading();
            const response = await this.fetchContent();
            this.updateModalContent(response);
            if (this.onSuccess) this.onSuccess(response);
        } catch (error) {
            // console.error('Error loading modal content:', error);
            if (this.onError) this.onError(error);
        }
    }

    showLoading() {
        if (this.modalBody) {
            this.modalBody.innerHTML = this.loadingHtml;
        }
    }

    async fetchContent() {
        return await HttpRequest.get(this.endpoint);
    }

    updateModalContent(response) {
        if (response && response.html && this.modalBody) {
            this.modalBody.innerHTML = response.html;
        }
    }

    // New method to manually load modal content
    async load() {
        await this.handleModalOpen();
    }
}

/**
 * SimpleWatcher - A lightweight class for observing DOM element additions and removals
 *
 * @class
 * @description Provides a simple way to watch for DOM elements being added or removed
 *
 * @param {Object} config - Configuration options
 * @param {string} config.targetSelector - CSS selector for the target element to observe
 * @param {string} [config.watchFor=''] - CSS selector for specific elements to watch for within target
 * @param {Function} [config.onElementFound] - Callback when matching elements are added
 * @param {Function} [config.onElementRemoved] - Callback when matching elements are removed
 *
 * @example
 * const watcher = new SimpleWatcher({
 *   targetSelector: '.content-section',
 *   watchFor: '.dynamic-element',
 *   onElementFound: () => console.log('Element added'),
 *   onElementRemoved: () => console.log('Element removed')
 * });
 *
 * // Control methods
 * watcher.disconnect(); // Stop watching
 * watcher.reconnect(); // Restart watching
 */
export class SimpleWatcher {
    constructor(config) {
        this.targetSelector = config.targetSelector;
        this.watchFor = config.watchFor || '';
        this.onElementFound = config.onElementFound || (() => { });
        this.onElementRemoved = config.onElementRemoved || (() => { });
        this.observer = null;

        this.initialize();
    }

    initialize() {
        const target = document.querySelector(this.targetSelector);

        if (!target) {
            console.warn(`Target element with selector "${this.targetSelector}" not found`);
            return;
        }

        this.observer = new MutationObserver((mutations) => {
            mutations.forEach((mutation) => {
                // Handle added nodes
                if (mutation.addedNodes.length) {
                    const hasMatchingElements = [...mutation.addedNodes].some(node =>
                        node.querySelector && (
                            this.watchFor ?
                                node.querySelector(this.watchFor) :
                                true
                        )
                    );

                    if (hasMatchingElements) {
                        this.onElementFound();
                    }
                }

                // Handle removed nodes
                if (mutation.removedNodes.length) {
                    const hasMatchingElements = [...mutation.removedNodes].some(node =>
                        node.querySelector && (
                            this.watchFor ?
                                node.querySelector(this.watchFor) :
                                true
                        )
                    );

                    if (hasMatchingElements) {
                        this.onElementRemoved();
                    }
                }
            });
        });

        this.observer.observe(target, {
            childList: true,
            subtree: true
        });
    }

    disconnect() {
        if (this.observer) {
            this.observer.disconnect();
            this.observer = null;
        }
    }

    reconnect() {
        if (!this.observer) {
            this.initialize();
        }
        return this;
    }
}

/**
 * LoadingBar - A reusable class for creating and managing loading bars
 *
 * @class LoadingBar
 * @exports LoadingBar
 *
 * @property {Object} options - Configuration options for the loading bar
 * @property {string} options.height - Height of the loading bar (default: '3px')
 * @property {string[]} options.colors - Array of colors for gradient background (default: ['#FFA500', '#FF8C00'])
 * @property {number} options.maxWidth - Maximum width percentage the bar will animate to before complete (default: 90)
 * @property {number} options.animationSpeed - Speed of the width animation in ms (default: 200)
 * @property {string} options.position - Position of bar, either 'top' or 'bottom' (default: 'top')
 * @property {HTMLElement} element - The loading bar DOM element
 * @property {number} interval - Reference to the animation interval
 */
export class LoadingBar {
    constructor(options = {}) {
        this.options = {
            height: options.height || '3px',
            colors: options.colors || ['#FFA500', '#FF8C00'],
            maxWidth: options.maxWidth || 90,
            animationSpeed: options.animationSpeed || 200,
            position: options.position || 'top',
            ...options
        };

        this.element = null;
        this.interval = null;
        this.create();
    }

    create() {
        this.element = document.createElement('div');

        const position = this.options.position === 'bottom' ? 'bottom: 0;' : 'top: 0;';
        const gradient = `linear-gradient(to right, ${this.options.colors.join(', ')})`;

        this.element.style.cssText = `
            position: fixed;
            ${position}
            left: 0;
            height: ${this.options.height};
            width: 0%;
            background: ${gradient};
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            z-index: 9999;
            box-shadow: 0 0 10px rgba(255, 165, 0, 0.5);
            border-radius: 0 4px 4px 0;
            opacity: 0;
            transform: translateY(-100%);
        `;

        document.body.appendChild(this.element);

        // Trigger reflow for smooth entrance animation
        this.element.offsetHeight;
        this.element.style.opacity = '1';
        this.element.style.transform = 'translateY(0)';

        return this;
    }

    start() {
        let width = 0;
        let acceleration = 1;

        this.interval = setInterval(() => {
            if (width < this.options.maxWidth) {
                // Dynamic acceleration for more natural progress
                acceleration = Math.max(0.1, acceleration * 0.98);
                width += Math.random() * 8 * acceleration;

                // Add slight oscillation for more dynamic effect
                const oscillation = Math.sin(Date.now() / 500) * 0.5;
                const finalWidth = Math.min(this.options.maxWidth, width + oscillation);

                this.element.style.width = `${finalWidth}%`;
                this.element.style.boxShadow = `0 0 ${10 + oscillation * 5}px rgba(255, 165, 0, 0.5)`;
            }
        }, this.options.animationSpeed / 2);
        return this;
    }

    complete() {
        if (!this.element) return;

        this.element.style.transition = 'all 0.5s cubic-bezier(0.4, 0, 0.2, 1)';
        this.element.style.width = '100%';
        this.element.style.boxShadow = '0 0 20px rgba(255, 165, 0, 0.8)';

        setTimeout(() => {
            this.element.style.opacity = '0';
            this.element.style.transform = 'translateY(-100%)';
            setTimeout(() => this.remove(), 500);
        }, 300);
    }

    error() {
        if (!this.element) return;

        this.element.style.transition = 'all 0.3s cubic-bezier(0.4, 0, 0.2, 1)';
        this.element.style.background = 'linear-gradient(to right, #ff4444, #cc0000)';
        this.element.style.boxShadow = '0 0 15px rgba(255, 0, 0, 0.6)';

        // Shake animation
        const shake = [
            { transform: 'translateX(-8px)' },
            { transform: 'translateX(8px)' },
            { transform: 'translateX(-4px)' },
            { transform: 'translateX(4px)' },
            { transform: 'translateX(0)' }
        ];

        this.element.animate(shake, {
            duration: 500,
            iterations: 1
        });

        setTimeout(() => {
            this.element.style.opacity = '0';
            this.element.style.transform = 'translateY(-100%)';
            setTimeout(() => this.remove(), 500);
        }, 1000);
    }

    remove() {
        if (this.interval) {
            clearInterval(this.interval);
        }
        if (this.element) {
            this.element.remove();
            this.element = null;
        }
    }
}

/**
 * CountdownTimer - A class for managing countdown timers with storage and callbacks
 *
 * @class
 * @description Handles countdown timing with local storage persistence and callback support
 *
 * @param {Object} options - Configuration options
 * @param {Object} options.duration - Duration object with minutes and/or seconds
 * @param {number} [options.duration.minutes=0] - Minutes for countdown
 * @param {number} [options.duration.seconds=0] - Seconds for countdown
 * @param {Array} [options.callbacks=[]] - Array of callback objects with time and function
 * @param {string} options.elementId - ID of element to display timer
 * @param {string} [options.storageKey] - Key for localStorage to persist timer state
 * @param {Function} [options.onFinish] - Callback function when timer finishes
 *
 * @example
 * const timer = new CountdownTimer({
 *   duration: { minutes: 5, seconds: 30 },
 *   callbacks: [
 *     { time: 60, callback: () => console.log('1 minute remaining!') }
 *   ],
 *   elementId: 'timer-display',
 *   storageKey: 'myTimer',
 *   onFinish: () => console.log('Timer finished!')
 * });
 *
 * timer.start();  // Start the timer
 * timer.pause();  // Pause the timer
 * timer.resume(); // Resume the timer
 * timer.reset();  // Reset the timer
 */
export class CountdownTimer {
    constructor(options) {
        this.duration = {
            minutes: options.duration?.minutes || 0,
            seconds: options.duration?.seconds || 0
        };
        this.callbacks = options.callbacks || [];
        this.elementId = options.elementId;
        this.storageKey = options.storageKey;
        this.onFinish = options.onFinish || (() => { });

        this.element = document.getElementById(this.elementId);
        this.interval = null;
        this.remainingTime = this.getTotalSeconds();
        this.isRunning = false;

        // Load saved time if storage key provided
        if (this.storageKey) {
            const savedTime = localStorage.getItem(this.storageKey);
            if (savedTime) {
                this.remainingTime = parseInt(savedTime);
            }
        }
    }

    getTotalSeconds() {
        return (this.duration.minutes * 60) + this.duration.seconds;
    }

    formatTime(seconds) {
        const minutes = Math.floor(seconds / 60);
        const remainingSeconds = seconds % 60;
        return `${String(minutes).padStart(2, '0')}:${String(remainingSeconds).padStart(2, '0')}`;
    }

    start() {
        if (this.isRunning) return;

        this.isRunning = true;
        this.interval = setInterval(() => {
            this.remainingTime--;

            // Update display
            if (this.element) {
                this.element.textContent = this.formatTime(this.remainingTime);
            }

            // Save to localStorage if key provided
            if (this.storageKey) {
                localStorage.setItem(this.storageKey, this.remainingTime.toString());
            }

            // Check callbacks
            this.callbacks.forEach(callback => {
                if (this.remainingTime === callback.time) {
                    callback.callback();
                }
            });

            // Check if timer is finished
            if (this.remainingTime <= 0) {
                this.stop();
                this.onFinish();
            }
        }, 1000);
    }

    pause() {
        clearInterval(this.interval);
        this.isRunning = false;
    }

    resume() {
        if (this.remainingTime > 0) {
            this.start();
        }
    }

    stop() {
        clearInterval(this.interval);
        this.isRunning = false;
        if (this.storageKey) {
            localStorage.removeItem(this.storageKey);
        }
    }

    reset() {
        this.stop();
        this.remainingTime = this.getTotalSeconds();
        if (this.element) {
            this.element.textContent = this.formatTime(this.remainingTime);
        }
    }

    getRemainingTime() {
        return this.remainingTime;
    }
}

/**
 * DatatableController is a class that handles the initialization of the DataTable library.
 *
 * @param {string} tableId - The ID of the table to be handled
 * @param {Object} [options] - The options for the DataTable
 * @param {Object} [options.customFunctions] - Custom functions to be added to the DataTable
 * @param {Object} [options.eventListeners] - Event listeners to be added to the DataTable
 * @param {Object} [options.ajax] - Ajax options for the DataTable
 * @param {Object} [options.select] - Select options for the DataTable
 * @param {Object} [options.lengthMenu] - Length menu options for the DataTable
 * @param {Object} [options.order] - Order options for the DataTable
 * @param {Object} [options.searchSelector] - Search selector for the DataTable
 * @param {Object} [options.filterSelector] - Filter selector for the DataTable
 * @param {Object} [options.stateSave] - State save options for the DataTable
 * @param {Object} [options.onDraw] - Function to be called when the DataTable is drawn
 *
 * @example
 * const usersDataTable = new $DatatableController('kt_datatable_example_1', {
 *
 *  lengthMenu: [[5, 10, 20, 50, -1], [5, 10, 20, 50, "All"]],
 *  toggleToolbar: true,
 *  initColumnVisibility: true,
 *
 *  selectedAction: (selectedIds) => {
 *
 *      console.log('Performing action on ids:', selectedIds);
 *
 *  },
 *
 *   ajax: {
 *       url: `${__API_CFG__.BASE_URL}/dashboard/users/data`,
 *       data: (d) => ({
 *           ...d,
 *           name_with_4_letter: document.querySelector('input[name="name_with_4_letter"]').checked,
 *           name_with_5_letter: document.querySelector('input[name="name_with_5_letter"]').checked
 *       })
 *   },
 *
 *    columns: [
 *        { data: 'id' },
 *        { data: 'name' },
 *        { data: 'email' },
 *        { data: 'created_at' },
 *       { data: 'status' },
 *       { data: null },
 *    ],
 *
 *    columnDefs: $DatatableController.generateColumnDefs([
 *        { targets: [0], htmlType: 'selectCheckbox' },
 *        { targets: [1], htmlType: 'badge', badgeClass: 'badge-light-danger' },
 *        {
 *            targets: [4], htmlType: 'toggle',
 *            checkWhen: (data, type, row) => {
 *                return data === 'in';
 *           },
 *            uncheckWhen: (data, type, row) => {
 *                return data === 'pending';
 *            }
 *        },
 *        { targets: [-1], htmlType: 'actions', className: 'text-center', actionButtons: { edit: true, delete: true, view: true } },
 *    ]),
 *
 *    // Custom functions
 *    customFunctions: {
 *
 *        delete: async function (endpoint, onSuccess, onError) {
 *            try {
 *                const result = await SweetAlert.deleteAction();
 *                if (result) {
 *                    const response = await HttpRequest.del(endpoint);
 *                    onSuccess(response);
 *                }
 *            } catch (error) {
 *                onError(error);
 *            }
 *        },
 *
 *        show: async function (id, endpoint, onSuccess, onError) {
 *            console.log("Show user", id);
 *        },
 *
 *        edit: async function (id, endpoint, onSuccess, onError) {
 *            console.log("Edit user", id);
 *        },
 *
 *        updateStatus: async function (id, newStatus, onSuccess, onError) {
 *            try {
 *               const response = await HttpRequest.put(`${__API_CFG__.BASE_URL}/dashboard/users/update-status/${id}`, { status: newStatus });
 *                onSuccess(response);
 *            } catch (error) {
 *                onError(error);
 *            }
 *        },
 *    },
 *
 *    eventListeners: [
 *        {
 *            event: 'click',
 *            selector: '.delete-btn',
 *            handler: function (id, event) {
 *                this.callCustomFunction(
 *                    'delete',
 *                    `${__API_CFG__.BASE_URL}/dashboard/users/delete/${id}`,
 *                    (res) => {
 *                        if (res.risk) {
 *                            SweetAlert.error();
 *                        } else {
 *                            SweetAlert.deleteSuccess();
 *                            this.reload();
 *                        }
 *                    },
 *                    (err) => { console.error('Error deleting user', err); }
 *                );
 *            }
 *        },
 *        {
 *            event: 'click',
 *            selector: '.status-toggle',
 *            handler: function (id, event) {
 *                const toggle = event.target;
 *                const newStatus = toggle.checked ? 'in' : 'pending';
 *                this.callCustomFunction('updateStatus', id, newStatus,
 *                    (res) => {
 *                        Toast.showSuccessToast('', res.message);
 *                        toggle.dataset.currentStatus = newStatus;
 *                    },
 *                    (err) => {
 *                        console.error('Error updating status', err);
 *                        SweetAlert.error('Failed to update status');
 *                        toggle.checked = !toggle.checked;
 *                    }
 *                );
 *            }
 *        },
 *        {
 *            event: 'click',
 *           selector: '.btn-show',
 *           handler: function (id, event) {
 *               this.callCustomFunction('show', id);
 *            }
 *        },
 *        {
 *            event: 'click',
 *            selector: '.btn-edit',
 *            handler: function (id, event) {
 *               this.callCustomFunction('edit', id);
 *            }
 *        }
 *    ],
 * });
 *
 *
 * function addUser() {
 *    FunctionUtility.closeModalWithButton('kt_modal_stacked_2', '.close-modal', () => {
 *        FunctionUtility.clearForm('#add-user-form');
 *    });
 *
 *    const addUserConfig = {
 *        formSelector: '#add-user-form',
 *        externalButtonSelector: '#add-user-button',
 *        endpoint: `${__API_CFG__.BASE_URL}/dashboard/users/create`,
 *        feedback: true,
 *        onSuccess: (res) => {
 *            Toast.showNotificationToast('', res.message)
 *            FunctionUtility.closeModal('kt_modal_stacked_2', () => {
 *                FunctionUtility.clearForm('#add-user-form');
 *            });
 *            usersDataTable.reload();
 *        },
 *        onError: (err) => { console.error('Error adding user', err); },
 *    };
 *
 * const form = new $SingleFormPostController(addUserConfig);
 * form.init();
 *
 * addUser();
 *
 */
export class $DatatableController {
    constructor(tableId, options = {}) {
        this.tableId = tableId;
        this.options = this.mergeOptions(options);
        this.dt = null;
        this.customFunctions = new Map();
        this.eventListeners = new Map();
        this.init();
    }

    mergeOptions(options) {
        const defaultOptions = {
            searchDelay: dataTableConfig.SEARCH_DELAY,
            processing: dataTableConfig.PROCESSING,
            serverSide: dataTableConfig.SERVER_SIDE,
            order: [[3, 'desc']],
            lengthMenu: [[dataTableConfig.LENGTH_MENU], [dataTableConfig.LENGTH_MENU_TEXT]],
            stateSave: dataTableConfig.STATE_SAVE,
            select: {
                style: 'multi',
                selector: 'td:first-child input[type="checkbox"]',
                className: 'row-selected'
            },
            ajax: {
                error: (xhr) => {

                }
            },

            // search cfg
            search: dataTableConfig.ENABLE_SEARCH,
            searchSelector: '[data-table-filter="search"]',

            // filter cfg
            filter: dataTableConfig.ENABLE_FILTER,
            filterBoxSelector: '.filter-toolbar',
            filterMenuSelector: '#filter-menu',
            filterSelector: '[data-table-filter="filter"]',
            resetFilterSelector: '[data-table-reset="filter"]',
            resetFilter: dataTableConfig.ENABLE_RESET_FILTER,

            // column cfg
            columnVisibility: dataTableConfig.ENABLE_COLUMN_VISIBILITY,
            columnVisibilitySelector: '.column-visibility-container',

            // create cfg
            createButtonSelector: '.create',

            //
            toggleToolbar: dataTableConfig.ENABLE_TOGGLE_TOOLBAR,
            selectedCountSelector: '[data-table-toggle-select-count="selected_count"]',
            selectedActionSelector: '[data-table-toggle-action-btn="selected_action"]',
            toolbarBaseSelector: '[data-table-toggle-base="base"]',
            toolbarSelectedSelector: '[data-table-toggle-selected="selected"]',

            // Custom action
            selectedAction: null,
        };
        return { ...defaultOptions, ...options };
    }

    init() {
        this.initDatatable();
        this.setupCustomFunctions();
        this.setupEventListeners();
        this.attachDefaultListeners();
        this.setupSelectAllCheckbox();
        this.attachResetListener();
    }

    initDatatable() {
        this.dt = $(`#${this.tableId}`).DataTable({
            ...this.options,
            language: {
                "sEmptyTable": l10n.getRandomTranslation('sEmptyTable'),
                "sInfo": l10n.getRandomTranslation('sInfo'),
                "sInfoEmpty": l10n.getRandomTranslation('sInfoEmpty'),
                "sInfoFiltered": l10n.getRandomTranslation('sInfoFiltered'),
                "sLoadingRecords": l10n.getRandomTranslation('sLoadingRecords'),
                // "sProcessing": l10n.getRandomTranslation('sProcessing'),
                "sSearch": l10n.getRandomTranslation('sSearch'),
                "sZeroRecords": l10n.getRandomTranslation('sZeroRecords'),
                "oPaginate": {
                    "sFirst": l10n.getRandomTranslation('sFirst'),
                    "sLast": l10n.getRandomTranslation('sLast'),
                    "sNext": l10n.getRandomTranslation('sNext'),
                    "sPrevious": l10n.getRandomTranslation('sPrevious')
                },
                "oAria": {
                    "sSortAscending": l10n.getRandomTranslation('sSortAscending'),
                    "sSortDescending": l10n.getRandomTranslation('sSortDescending')
                }
            }
        });

        // Initialize KTMenu after each draw
        this.dt.on('draw', () => {
            // Initialize KTMenu for new dropdowns
            KTMenu.init(); // Initialize all new menus
            KTMenu.createInstances(); // Create instances for new menus

            if (typeof this.options.onDraw === 'function') {
                this.options.onDraw.call(this);
            }

            if (l10n.currentLocale == "ar") {
                const pagText = document.getElementById('dt-length-1');
                pagText.style.marginLeft = '10px';
            }
        });
    }

    resetCheckboxes() {
        let filterMenu = document.querySelector(this.options.filterBoxSelector);
        const inputs = filterMenu.querySelectorAll('input');
        inputs.forEach(input => {
            input.value = '';
            if (input.type === 'checkbox') {
                input.checked = false;
            }
        });
    }

    attachResetListener() {
        if (!this.options.resetFilter) return;

        const resetButton = document.querySelector(this.options.resetFilterSelector);
        if (resetButton) {
            resetButton.addEventListener('click', () => {
                let filterMenu = document.querySelector(this.options.filterBoxSelector);
                const inputs = filterMenu.querySelectorAll('input, select');
                inputs.forEach(input => {
                    if (input.type === 'checkbox') {
                        input.checked = false;
                    } else if (input.tagName === 'SELECT') {
                        input.value = '';
                        if ($(input).data('select2')) {
                            $(input).val(null).trigger('change');
                        }
                    } else {
                        input.value = '';
                    }
                });
                this.reload();
            });
        }
    }

    initToggleToolbar() {
        if (!this.options.toggleToolbar) return;

        const container = document.querySelector(`#${this.tableId}`);
        const actionButton = document.querySelector(this.options.selectedActionSelector);

        container.addEventListener('change', (e) => {
            if (e.target.type === 'checkbox' && e.target.classList.contains('row-select-checkbox')) {
                setTimeout(() => this.toggleToolbars(), 50);
            }
        });

        if (actionButton && this.options.selectedAction) {
            actionButton.addEventListener('click', () => {
                const selectedIds = this.getSelectedIds();
                this.options.selectedAction(selectedIds, () => this.reload());
            });
        }
    }

    getSelectedIds() {
        const selectedCheckboxes = document.querySelectorAll(`#${this.tableId} tbody input.row-select-checkbox:checked`);
        return Array.from(selectedCheckboxes).map(checkbox => checkbox.value);
    }

    toggleToolbars() {
        if (!this.options.toggleToolbar) return;

        const container = document.querySelector(`#${this.tableId}`);
        const toolbarBase = document.querySelector(this.options.toolbarBaseSelector);
        const toolbarSelected = document.querySelector(this.options.toolbarSelectedSelector);
        const selectedCount = document.querySelector(this.options.selectedCountSelector);
        const allCheckboxes = container.querySelectorAll('tbody .row-select-checkbox');
        const filterToolbar = document.querySelector(this.options.filterBoxSelector);
        const createButton = document.querySelector(this.options.createButtonSelector);

        let checkedState = false;
        let count = 0;

        allCheckboxes.forEach(c => {
            if (c.checked) {
                checkedState = true;
                count++;
            }
        });

        if (toolbarSelected && toolbarBase && selectedCount) {
            if (checkedState) {
                selectedCount.innerHTML = `${count}`;
                toolbarBase.classList.add('d-none');
                toolbarSelected.classList.remove('d-none');
                createButton.classList.add('d-none');
                filterToolbar.classList.add('d-none');
            } else {
                toolbarBase.classList.remove('d-none');
                toolbarSelected.classList.add('d-none');
                createButton.classList.remove('d-none');
                filterToolbar.classList.remove('d-none');
            }
        } else {
            console.error('One or more toolbar elements not found');
        }
    }

    initColumnVisibility() {
        if (!this.options.columnVisibility) return;

        const container = document.querySelector(`#${this.tableId}_wrapper`);
        if (!container) return;

        const menuBody = document.getElementById('column-toggles');
        if (!menuBody) return;

        menuBody.innerHTML = '';

        this.dt.columns().every(function (index) {
            const column = this;
            const title = column.header().textContent.trim();

            const toggleContainer = document.createElement('div');
            toggleContainer.className = 'form-check form-switch form-check-custom form-check-solid mb-3';

            const checkbox = document.createElement('input');
            checkbox.className = 'form-check-input';
            checkbox.type = 'checkbox';
            checkbox.checked = column.visible();
            checkbox.id = `column_toggle_${index}`;

            const label = document.createElement('label');
            label.className = 'form-check-label';
            label.htmlFor = `column_toggle_${index}`;
            label.textContent = title;

            checkbox.addEventListener('change', function () {
                column.visible(this.checked);
            });

            toggleContainer.appendChild(checkbox);
            toggleContainer.appendChild(label);
            menuBody.appendChild(toggleContainer);
        });

        // Add the button container to the DataTable wrapper if it's not already added
        const buttonContainer = document.querySelector('.column-visibility-container');
        const tableControlsContainer = container.querySelector('.dataTables_wrapper .row:first-child .col-sm-6:last-child');
        if (tableControlsContainer && !tableControlsContainer.contains(buttonContainer)) {
            tableControlsContainer.appendChild(buttonContainer);
        }
        KTMenu.createInstances();
    }

    attachDefaultListeners() {
        if (this.options.search) this.attachSearchListener();
        if (this.options.filter) this.attachFilterListener();
        if (this.options.toggleToolbar) this.initToggleToolbar();
        if (this.options.resetFilter) this.attachResetListener();
        if (this.options.columnVisibility) this.initColumnVisibility();
    }

    attachFilterListener() {
        const filterElement = document.querySelector(this.options.filterSelector);
        if (filterElement) {
            filterElement.addEventListener('click', () => this.reload());
        }
    }

    attachSearchListener() {
        const searchElement = document.querySelector(this.options.searchSelector);
        if (searchElement) {
            searchElement.addEventListener('keyup', (e) => {
                this.dt.search(e.target.value).draw();
            });
        }
    }

    setupCustomFunctions() {
        if (this.options.customFunctions) {
            for (const [name, func] of Object.entries(this.options.customFunctions)) {
                this.addCustomFunction(name, func);
            }
        }
    }

    addCustomFunction(name, func) {
        this.customFunctions.set(name, func.bind(this));
    }

    setupEventListeners() {
        if (this.options.eventListeners) {
            for (const listener of this.options.eventListeners) {
                this.addEventListener(listener.event, listener.selector, listener.handler);
            }
        }
    }

    addEventListener(event, selector, handler) {
        const wrappedHandler = (e) => {
            const id = e.currentTarget.getAttribute('data-id');
            handler.call(this, id, e);
        };
        $(`#${this.tableId}`).on(event, selector, wrappedHandler);

        if (!this.eventListeners.has(event)) {
            this.eventListeners.set(event, new Map());
        }
        this.eventListeners.get(event).set(selector, wrappedHandler);
    }

    removeEventListener(event, selector) {
        if (this.eventListeners.has(event) && this.eventListeners.get(event).has(selector)) {
            $(`#${this.tableId}`).off(event, selector, this.eventListeners.get(event).get(selector));
            this.eventListeners.get(event).delete(selector);
        }
    }

    setupSelectAllCheckbox() {
        const tableId = this.tableId;
        const selectAllCheckbox = document.querySelector(`#${tableId} .select-all-checkbox`);

        if (selectAllCheckbox) {
            selectAllCheckbox.addEventListener('click', (e) => {
                const isChecked = e.target.checked;
                const rowCheckboxes = document.querySelectorAll(`#${tableId} .row-select-checkbox`);

                rowCheckboxes.forEach(checkbox => {
                    checkbox.checked = isChecked;
                });

                this.toggleToolbars();
            });

            // Update "select all" checkbox state when individual checkboxes change
            document.querySelector(`#${tableId} tbody`).addEventListener('change', (e) => {
                if (e.target.classList.contains('row-select-checkbox')) {
                    const allCheckboxes = document.querySelectorAll(`#${tableId} .row-select-checkbox`);
                    const checkedCheckboxes = document.querySelectorAll(`#${tableId} .row-select-checkbox:checked`);
                    selectAllCheckbox.checked = allCheckboxes.length === checkedCheckboxes.length;

                    this.toggleToolbars();
                }
            });
        }
    }

    reload() {
        this.dt.ajax.reload(null, false);
    }

    callCustomFunction(functionName, ...args) {
        if (this.customFunctions.has(functionName)) {
            return this.customFunctions.get(functionName)(...args);
        } else {
            console.error(`Custom function ${functionName} not found`);
        }
    }

    destroy() {
        this.dt.destroy();
        this.eventListeners.forEach((listeners, event) => {
            listeners.forEach((_, selector) => {
                this.removeEventListener(event, selector);
            });
        });
        this.customFunctions.clear();
        this.eventListeners.clear();
    }

    getDataTable() {
        return this.dt;
    }

    static generateColumnDefs(columnConfigs) {
        return columnConfigs.map(config => {
            const {
                htmlType, targets, orderable = dataTableConfig.ORDERABLE,
                className = '', customRender, checkWhen,
                uncheckWhen, hrefFunction, dataClassName = '',
                actionButtons = dataTableConfig.ACTION_BUTTONS,
                badgeClass = ''
            } = config;

            let renderFunction;

            switch (htmlType) {

                case 'link':
                    renderFunction = function (data, type, row) {
                        const href = typeof hrefFunction === 'function' ? hrefFunction(data, type, row) : data;
                        return `<a href="${href}" target="_blank" class="${dataClassName}">${data}</a>`;
                    };
                    break;

                case 'number':
                    renderFunction = function (data) {
                        return `<span class="${dataClassName}">${Number(data).toLocaleString()}</span>`;
                    };
                    break;

                case 'badge':
                    renderFunction = function (data) {
                        return `<span class="badge ${badgeClass} ${dataClassName}">${data}</span>`;
                    };
                    break;

                case 'icon':
                    renderFunction = function (data) {
                        return `<i class="${data} ${dataClassName}"></i>`;
                    };
                    break;

                case 'image':
                    renderFunction = function (data) {
                        return `<div style="width: 50px; height: 50px; background-image: url('${data}'); background-size: cover; background-position: center; background-repeat: no-repeat; border-radius: 4px;"></div>`;
                    };
                    break;

                case 'toggle':
                    renderFunction = function (data, type, row, meta) {
                        // Default check/uncheck conditions if not provided
                        const defaultCheckWhen = (data) => {
                            return data == true || data == "1" || data == "show" || data == 1 ||
                                data == "true" || data == "active" || data == "on" ||
                                data == "Active" || data == "Show";
                        };

                        const defaultUncheckWhen = (data) => {
                            return data == false || data == "0" || data == "hide" || data == 0 ||
                                data == "false" || data == "inactive" || data == "off" ||
                                data == "Inactive" || data == "Hide";
                        };

                        // Use provided functions or defaults
                        const checkFunction = typeof checkWhen === 'function' ? checkWhen : defaultCheckWhen;
                        const uncheckFunction = typeof uncheckWhen === 'function' ? uncheckWhen : defaultUncheckWhen;

                        const isChecked = checkFunction(data, type, row);
                        const isUnchecked = uncheckFunction(data, type, row);

                        if (isChecked && isUnchecked) {
                            console.warn("Both checkWhen and uncheckWhen are defined. Only checkWhen will be considered.");
                        }

                        // Generate unique ID using column name or index
                        const columnName = meta.settings.aoColumns[meta.col].data || meta.col;
                        const uniqueId = `${columnName}_${row.id}`;

                        return `
            <div class="form-check form-switch">
                <input class="form-check-input ${dataClassName}" type="checkbox"
                    id="${uniqueId}"
                    ${isChecked || (data === 'active' && !isUnchecked) ? 'checked' : ''}
                    data-id="${row.id}">
            </div>
        `;
                    };
                    break;

                case 'selectCheckbox':
                    renderFunction = function (data, type, row) {
                        return `
                            <div class="form-check form-check-sm form-check-custom form-check-solid">
                                <input class="form-check-input row-select-checkbox" type="checkbox" value="${row.id}" />
                            </div>
                        `;
                    };
                    break;

                case 'actions':
                    renderFunction = function (data) {
                        const generateButton = (action, config) => {
                            // If config is null/undefined or false, don't render the button
                            if (!config) return '';

                            // If config is true, use default modal configuration
                            const buttonConfig = config === true ? { type: 'modal' } : config;
                            const type = buttonConfig.type || 'modal'; // Default to modal
                            const baseClasses = 'btn datatable-btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1';

                            // Button configurations
                            const buttonConfigs = {
                                edit: {
                                    icon: 'bi bi-pencil fs-5',
                                    color: '#007bff',
                                    title: 'Edit',
                                    class: 'btn-edit data-table-action-edit',
                                    modalTarget: '#edit-modal'
                                },
                                view: {
                                    icon: 'bi bi-eye fs-5',
                                    color: '#28a745',
                                    title: 'View',
                                    class: 'btn-show mx-2 data-table-action-show',
                                    modalTarget: '#show-modal'
                                },
                                delete: {
                                    icon: 'bi bi-trash3-fill fs-5',
                                    color: '#dc3545',
                                    title: 'Delete',
                                    class: 'delete-btn mx-2 data-table-action-delete'
                                }
                            };

                            const btnConfig = buttonConfigs[action];
                            if (!btnConfig) return '';

                            // Attributes based on type
                            let additionalAttrs = '';
                            if (type === 'modal') {
                                const modalTarget = buttonConfig.modalTarget || btnConfig.modalTarget;
                                additionalAttrs = `data-bs-toggle="modal" data-bs-target="${modalTarget}"`;
                            } else if (type === 'redirect') {
                                additionalAttrs = `href="${buttonConfig.url || '#'}"`;
                            }

                            // Element type based on redirect
                            const element = type === 'redirect' ? 'a' : 'button';

                            return `
                                    <${element}
                                        data-id="${data.id}"
                                        ${additionalAttrs}
                                        type="button"
                                        class="${baseClasses} ${btnConfig.class}"
                                        data-action-type="${type || 'none'}"
                                        data-bs-toggle="tooltip"
                                        data-bs-placement="top"
                                        title="${btnConfig.title}">
                                        <i class="${btnConfig.icon}" style="color: ${btnConfig.color};"></i>
                                    </${element}>
                                `;
                        };

                        return `
                                <div class="btn-group" role="group">
                                    ${generateButton('edit', actionButtons.edit)}
                                    ${generateButton('view', actionButtons.view)}
                                    ${generateButton('delete', actionButtons.delete)}
                                </div>`;
                    };
                    break;

                case 'dropdownActions':
                    renderFunction = function (data, type, row) {
                        const generateDropdownItem = (action, config) => {
                            // If config is false or has a show condition that evaluates to false, don't render
                            if (!config || (config.showIf && !config.showIf(row))) return '';

                            const {
                                icon = 'bi bi-gear',
                                text = action.charAt(0).toUpperCase() + action.slice(1),
                                class: customClass = '',
                                menuItemClass = '',
                                type = null,
                                modalTarget,
                                url,
                                callback,
                                color = 'primary',
                                divider = false
                            } = config;

                            if (divider) {
                                return '<div class="separator my-2"></div>';
                            }

                            let additionalAttrs = '';
                            let finalClass = customClass; // Create mutable class variable

                            if (type) {
                                if (type !== 'modal' && type !== 'redirect' && type !== 'callback') {
                                    console.error(`Invalid type "${type}" for action "${action}". Only "modal", "redirect", "callback" or null are allowed.`);
                                    return '';
                                }

                                if (type === 'modal') {
                                    if (!modalTarget) {
                                        console.error(`modalTarget is required for modal action "${action}"`);
                                        return '';
                                    }
                                    additionalAttrs = `data-bs-toggle="modal" data-bs-target="${modalTarget}"`;
                                } else if (type === 'redirect') {
                                    if (!url) {
                                        console.error(`url is required for redirect action "${action}"`);
                                        return '';
                                    }
                                    const finalUrl = typeof url === 'function' ? url(row) : url;
                                    additionalAttrs = `href="${finalUrl}"`;
                                } else if (type === 'callback') {
                                    if (!callback || typeof callback !== 'function') {
                                        console.error(`callback function is required for callback action "${action}"`);
                                        return '';
                                    }
                                    const callbackId = `callback_${action}_${Math.random().toString(36).substr(2, 9)}`;
                                    window[callbackId] = {
                                        callback,
                                        rowData: row
                                    };
                                    additionalAttrs = `data-callback-id="${callbackId}"`;
                                    finalClass += ' callback-action'; // Use mutable variable
                                }
                            }

                            return `
                                <div class="menu-item px-3 ${menuItemClass}">
                                    <a class="menu-link px-3 ${finalClass}"
                                       data-id="${data.id}"
                                       ${additionalAttrs}
                                       style="cursor: pointer"
                                       ${type ? `data-action-type="${type}"` : ''}>
                                        <span class="menu-icon me-3">
                                            <i class="${icon} fs-6 text-${color}"></i>
                                        </span>
                                        <span class="menu-title">${text}</span>
                                    </a>
                                </div>
                            `;
                        };

                        const dropdownId = `dropdown_${data.id}_${Math.random().toString(36).substr(2, 9)}`;

                        return `
                            <div class="d-flex justify-content-end">
                                <div class="dropdown ${actionButtons.containerClass || ''}" id="${dropdownId}">
                                    <button type="button"
                                            class="btn btn-sm btn-icon btn-light btn-active-light-primary ${actionButtons.buttonClass || ''}"
                                            data-kt-menu-trigger="click"
                                            data-kt-menu-placement="bottom-end">
                                        <i class="bi bi-three-dots fs-2"></i>
                                    </button>
                                    <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg-light-primary fw-semibold w-200px py-3 ${actionButtons.menuClass || ''}"
                                         data-kt-menu="true">
                                        ${Object.entries(actionButtons).map(([action, config]) =>
                            generateDropdownItem(action, config)
                        ).join('')}
                                    </div>
                                </div>
                            </div>
                        `;
                    };
                    break;

                default:
                    renderFunction = customRender || function (data) {
                        return `<span class="${dataClassName}">${data}</span>`;
                    };
                    break;
            }

            // Add event listener for callback actions using event delegation
            document.addEventListener('click', function (e) {
                if (e.target.closest('.callback-action')) {
                    const link = e.target.closest('.callback-action');
                    const callbackId = link.getAttribute('data-callback-id');
                    if (callbackId && window[callbackId]) {
                        const { callback, rowData } = window[callbackId];
                        callback(rowData);
                        // Clean up
                        delete window[callbackId];
                    }
                }
            }, { capture: true });

            return {
                targets: targets,
                orderable: orderable,
                className: className,
                render: renderFunction
            };
        });
    }
}

/**
 * SecurityManager - A reusable security class for preventing cheating in online assessments
 *
 * Features:
 * - Disables right-clicks
 * - Blocks keyboard shortcuts
 * - Detects tab/window changes
 * - Monitors for fullscreen exits
 * - Prevents copy/paste operations
 * - Automatically sends abort requests on suspicious behavior
 *
 * @class
 * @exports SecurityManager
 *
 * @example
 * const securityManager = new SecurityManager({
 *   endpoint: '/quizzes/5/attempt/10/abort',
 *   requestData: { reason: 'suspicious_activity' },
 *   warningThreshold: 2,
 *   autoAbortThreshold: 3,
 *   onWarning: (count, max) => showWarning(`Warning ${count}/${max}`),
 *   onAbort: () => window.location.href = '/quizzes'
 * });
 *
 * // Activate all security measures
 * securityManager.activate();
 *
 * // Deactivate when quiz is submitted
 * submitButton.addEventListener('click', () => securityManager.deactivate());
 */
export class SecurityManager {
    /**
     * Create a new security manager instance
     *
     * @param {Object} options - Configuration options
     * @param {string} options.endpoint - API endpoint for abort request
     * @param {Object} [options.requestData={}] - Additional data to send with abort request
     * @param {Object} [options.requestHeaders={}] - Custom headers for abort request
     * @param {string} [options.requestMethod='POST'] - HTTP method for abort request
     * @param {number} [options.warningThreshold=2] - Number of violations before warning
     * @param {number} [options.autoAbortThreshold=3] - Number of violations before auto-abort
     * @param {boolean} [options.detectVisibilityChange=true] - Detect tab/window changes
     * @param {boolean} [options.blockContextMenu=true] - Block right-click menu
     * @param {boolean} [options.blockKeyboardShortcuts=true] - Block keyboard shortcuts
     * @param {boolean} [options.blockCopyPaste=true] - Block copy/paste operations
     * @param {boolean} [options.detectFullscreenExit=false] - Detect fullscreen exit
     * @param {boolean} [options.requireFullscreen=false] - Require fullscreen mode
     * @param {Function} [options.onWarning] - Callback when warning threshold reached
     * @param {Function} [options.onAbort] - Callback when quiz is aborted
     * @param {Function} [options.onViolation] - Callback for any violation
     * @param {Function} [options.onActivate] - Callback when security is activated
     * @param {Function} [options.onDeactivate] - Callback when security is deactivated
     */
    constructor(options = {}) {
        this.options = {
            // Request configuration
            endpoint: null,
            requestData: {},
            requestHeaders: {},
            requestMethod: 'POST',

            // Thresholds
            warningThreshold: 2,
            autoAbortThreshold: 3,

            // Security features
            detectVisibilityChange: true,
            blockContextMenu: true,
            blockKeyboardShortcuts: true,
            blockCopyPaste: true,
            detectFullscreenExit: false,
            requireFullscreen: false,

            // Event callbacks
            onWarning: null,
            onAbort: null,
            onViolation: null,
            onActivate: null,
            onDeactivate: null,

            // Override with user options
            ...options
        };

        // Internal state
        this.violationCount = 0;
        this.isActive = false;
        this.eventHandlers = {};
        this.violationLog = [];

        // Validate required options
        if (!this.options.endpoint && this.options.autoAbortThreshold > 0) {
            console.warn('SecurityManager: No endpoint provided for abort requests');
        }
    }

    /**
     * Activate all configured security measures
     * @returns {SecurityManager} The security manager instance for chaining
     */
    activate() {
        if (this.isActive) return this;

        // Setup event handlers
        if (this.options.detectVisibilityChange) {
            this.setupVisibilityDetection();
        }

        if (this.options.blockContextMenu) {
            this.setupContextMenuBlocking();
        }

        if (this.options.blockKeyboardShortcuts) {
            this.setupKeyboardShortcutBlocking();
        }

        if (this.options.blockCopyPaste) {
            this.setupCopyPasteBlocking();
        }

        if (this.options.detectFullscreenExit) {
            this.setupFullscreenDetection();
        }

        if (this.options.requireFullscreen) {
            this.requestFullscreen();
        }

        this.isActive = true;

        if (typeof this.options.onActivate === 'function') {
            this.options.onActivate();
        }

        return this;
    }

    /**
     * Deactivate all security measures
     * @returns {SecurityManager} The security manager instance for chaining
     */
    deactivate() {
        if (!this.isActive) return this;

        // Remove all event listeners
        Object.entries(this.eventHandlers).forEach(([event, handler]) => {
            document.removeEventListener(event, handler, true);
        });

        this.eventHandlers = {};
        this.isActive = false;

        if (typeof this.options.onDeactivate === 'function') {
            this.options.onDeactivate();
        }

        return this;
    }

    /**
     * Setup detection for tab/window visibility changes
     * @private
     */
    setupVisibilityDetection() {
        this.eventHandlers.visibilityChange = () => {
            if (document.visibilityState === 'hidden') {
                this.handleViolation('tab_change', 'User switched tabs or minimized window');
            }
        };

        document.addEventListener('visibilitychange', this.eventHandlers.visibilityChange, true);
    }

    /**
     * Setup blocking of right-click context menu
     * @private
     */
    setupContextMenuBlocking() {
        this.eventHandlers.contextMenu = (e) => {
            e.preventDefault();
            e.stopPropagation();
            this.handleViolation('right_click', 'User attempted to use right-click menu');
            return false;
        };

        document.addEventListener('contextmenu', this.eventHandlers.contextMenu, true);
    }

    /**
     * Setup blocking of keyboard shortcuts
     * @private
     */
    setupKeyboardShortcutBlocking() {
        this.eventHandlers.keyDown = (e) => {
            // Block common shortcuts
            const blockedCombinations = [
                { key: 'c', ctrl: true },      // Copy
                { key: 'v', ctrl: true },      // Paste
                { key: 'x', ctrl: true },      // Cut
                { key: 'a', ctrl: true },      // Select All
                { key: 'p', ctrl: true },      // Print
                { key: 's', ctrl: true },      // Save
                { key: 'u', ctrl: true },      // View Source
                { key: 'f', ctrl: true },      // Find
                { key: 'g', ctrl: true },      // Find Next
                { key: 'j', ctrl: true },      // Dev Tools
                { key: 'i', ctrl: true },      // Inspect
                { key: 'F12', ctrl: false },   // Dev Tools
                { key: 'F5', ctrl: false },    // Refresh
                { key: 'Tab', alt: true },     // Alt+Tab
                { key: 'Escape', ctrl: false } // Escape (for fullscreen)
            ];

            const isBlocked = blockedCombinations.some(combo => {
                if (e.key.toLowerCase() === combo.key.toLowerCase()) {
                    if ((combo.ctrl && e.ctrlKey) || (!combo.ctrl && !e.ctrlKey)) {
                        return true;
                    }
                }
                return false;
            });

            if (isBlocked) {
                e.preventDefault();
                e.stopPropagation();
                this.handleViolation('keyboard_shortcut', `Blocked keyboard shortcut: ${e.key}`);
                return false;
            }
        };

        document.addEventListener('keydown', this.eventHandlers.keyDown, true);
    }

    /**
     * Setup blocking of copy/paste operations
     * @private
     */
    setupCopyPasteBlocking() {
        const copyEvents = ['copy', 'cut', 'paste'];

        copyEvents.forEach(eventName => {
            this.eventHandlers[eventName] = (e) => {
                e.preventDefault();
                e.stopPropagation();
                this.handleViolation('copy_paste', `User attempted to ${eventName}`);
                return false;
            };

            document.addEventListener(eventName, this.eventHandlers[eventName], true);
        });
    }

    /**
     * Setup detection for fullscreen exit
     * @private
     */
    setupFullscreenDetection() {
        this.eventHandlers.fullscreenChange = () => {
            if (!document.fullscreenElement) {
                this.handleViolation('fullscreen_exit', 'User exited fullscreen mode');

                // Auto request fullscreen again if required
                if (this.options.requireFullscreen) {
                    setTimeout(() => this.requestFullscreen(), 500);
                }
            }
        };

        document.addEventListener('fullscreenchange', this.eventHandlers.fullscreenChange, true);
    }

    /**
     * Request fullscreen mode
     * @returns {Promise} Promise that resolves when fullscreen is entered
     */
    requestFullscreen() {
        const docEl = document.documentElement;

        if (docEl.requestFullscreen) {
            return docEl.requestFullscreen();
        } else if (docEl.webkitRequestFullscreen) {
            return docEl.webkitRequestFullscreen();
        } else if (docEl.mozRequestFullScreen) {
            return docEl.mozRequestFullScreen();
        } else if (docEl.msRequestFullscreen) {
            return docEl.msRequestFullscreen();
        }

        return Promise.reject(new Error('Fullscreen API not supported'));
    }

    /**
     * Handle security violation by logging, warning, or aborting
     * @param {string} type - Type of violation
     * @param {string} details - Details about the violation
     * @private
     */
    handleViolation(type, details) {
        // Increment violation count
        this.violationCount++;

        // Log violation
        const violation = {
            type,
            details,
            timestamp: new Date().toISOString(),
            count: this.violationCount
        };

        this.violationLog.push(violation);

        // Call violation callback if provided
        if (typeof this.options.onViolation === 'function') {
            this.options.onViolation(violation);
        }

        // Check if warning threshold reached - use >= to ensure it triggers
        if (this.violationCount >= this.options.warningThreshold &&
            this.violationCount < this.options.autoAbortThreshold) {
            // Only show warning if we haven't shown one for this count yet
            if (!this.lastWarningCount || this.lastWarningCount < this.violationCount) {
                this.lastWarningCount = this.violationCount;

                if (typeof this.options.onWarning === 'function') {
                    this.options.onWarning(
                        this.violationCount,
                        this.options.autoAbortThreshold
                    );
                }
            }
        }

        // Check if auto-abort threshold reached
        if (this.violationCount >= this.options.autoAbortThreshold && !this.abortRequested) {
            this.abortAssessment(type);
        }
    }

    /**
     * Abort the assessment by sending a request to the server
     * @param {string} reason - Reason for aborting
     * @returns {Promise|null} Promise from the abort request or null if no endpoint
     */
    abortAssessment(reason = 'security_violation') {
        // Prevent multiple abort requests
        if (this.abortRequested) {
            return null;
        }

        this.abortRequested = true;

        if (!this.options.endpoint) {
            console.warn('QuizSecurityManager: Cannot abort - no endpoint provided');
            return null;
        }

        // Immediately deactivate all event handlers to prevent more violations
        this.deactivate();

        // Prepare request data
        const requestData = {
            ...this.options.requestData,
            reason,
            violations: this.violationLog,
            violationCount: this.violationCount
        };

        // Call onAbort only once before making the request
        if (typeof this.options.onAbort === 'function') {
            this.options.onAbort({ pending: true });
        }

        // Use axios instead of fetch for better Laravel integration
        const abortPromise = axios({
            url: this.options.endpoint,
            method: this.options.requestMethod,
            headers: {
                ...this.options.requestHeaders
            },
            data: requestData
        })
            .then(response => {
                // We've already called onAbort, so we don't call it again
                return response.data;
            })
            .catch(error => {
                console.error('Error aborting assessment:', error);
                throw error;
            });

        return abortPromise;
    }

    /**
     * Temporarily disable event handlers to prevent more violations during abort
     * @private
     */
    temporarilyDisableHandlers() {
        // Store current handlers
        const savedHandlers = { ...this.eventHandlers };

        // Deactivate all handlers
        this.deactivate();

        // Store saved handlers for potential reactivation
        this._savedHandlers = savedHandlers;
    }

    /**
     * Deactivate all security measures
     * @returns {SecurityManager} The security manager instance for chaining
     */
    deactivate() {
        if (!this.isActive) return this;

        // Remove all event listeners
        if (this.eventHandlers.visibilityChange) {
            document.removeEventListener('visibilitychange', this.eventHandlers.visibilityChange);
        }

        if (this.eventHandlers.contextMenu) {
            document.removeEventListener('contextmenu', this.eventHandlers.contextMenu);
        }

        if (this.eventHandlers.keyDown) {
            document.removeEventListener('keydown', this.eventHandlers.keyDown);
        }

        if (this.eventHandlers.copy) {
            document.removeEventListener('copy', this.eventHandlers.copy);
            document.removeEventListener('cut', this.eventHandlers.copy);
        }

        if (this.eventHandlers.paste) {
            document.removeEventListener('paste', this.eventHandlers.paste);
        }

        if (this.eventHandlers.fullscreenChange) {
            document.removeEventListener('fullscreenchange', this.eventHandlers.fullscreenChange);
            document.removeEventListener('webkitfullscreenchange', this.eventHandlers.fullscreenChange);
            document.removeEventListener('mozfullscreenchange', this.eventHandlers.fullscreenChange);
            document.removeEventListener('MSFullscreenChange', this.eventHandlers.fullscreenChange);
        }

        // Clear event handlers
        this.eventHandlers = {};

        this.isActive = false;

        if (typeof this.options.onDeactivate === 'function') {
            this.options.onDeactivate();
        }

        return this;
    }

    /**
     * Get the current violation count
     * @returns {number} Current violation count
     */
    getViolationCount() {
        return this.violationCount;
    }

    /**
     * Get the violation log
     * @returns {Array} Array of violation objects
     */
    getViolationLog() {
        return [...this.violationLog];
    }

    /**
     * Reset violation count and log
     * @returns {SecurityManager} The security manager instance for chaining
     */
    resetViolations() {
        this.violationCount = 0;
        this.violationLog = [];
        return this;
    }

    /**
     * Check if security is currently active
     * @returns {boolean} True if security measures are active
     */
    isSecurityActive() {
        return this.isActive;
    }
}

