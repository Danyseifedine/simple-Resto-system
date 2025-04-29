@extends('web.layout.layout')

@section('content')
    <div style="min-height: 100vh; display: flex; align-items: center; justify-content: center;" class="container mx-auto">
        <div class="row justify-content-center" style="width: 1000px; padding-top: 150px !important;">
            <div class="col-lg-10">
                <div class="card shadow-lg border-0 rounded-lg mb-4"
                    style="background: linear-gradient(135deg, #f8f9fa, #e9ecef);">

                    <div class="card-body p-5">
                        <div class="text-center mb-4">
                            <h4 class="fw-bold text-primary">Find Foods That Match Your Dietary Needs</h4>
                            <p class="text-muted">Select your allergies and we'll recommend suitable menu items</p>
                        </div>

                        <div class="mb-4">
                            <div style="display: flex; flex-direction: column; gap: 10px;">
                                <label for="allergies" class="form-label fw-bold">Select Your Allergies:</label>
                                <select id="allergies" class="form-select form-select-lg shadow-sm" multiple
                                    style="border-radius: 15px; transition: all 0.3s; min-height: 150px;">
                                    <option value="dairy">Dairy (Milk, Cheese, Yogurt)</option>
                                    <option value="eggs">Eggs</option>
                                    <option value="peanuts">Peanuts</option>
                                    <option value="tree_nuts">Tree Nuts (Almonds, Walnuts, etc.)</option>
                                    <option value="soy">Soy</option>
                                    <option value="wheat">Wheat</option>
                                    <option value="gluten">Gluten</option>
                                    <option value="fish">Fish</option>
                                    <option value="shellfish">Shellfish (Shrimp, Crab, etc.)</option>
                                    <option value="sesame">Sesame</option>
                                    <option value="mustard">Mustard</option>
                                    <option value="celery">Celery</option>
                                    <option value="lupin">Lupin</option>
                                    <option value="sulfites">Sulfites</option>
                                    <option value="nightshades">Nightshades (Tomatoes, Peppers, etc.)</option>
                                </select>
                            </div>
                            <div class="form-text text-muted text-center mt-2">
                                <i class="fas fa-lightbulb text-warning me-1"></i> Hold Ctrl/Cmd to select multiple
                                allergies
                            </div>
                        </div>

                        <div class="d-grid gap-2 d-md-flex justify-content-center mb-4">
                            <button id="clearButton" class="btn btn-outline-secondary btn-lg px-4"
                                style="border-radius: 10px;">
                                <i class="fas fa-eraser me-1"></i> Clear
                            </button>
                            <button id="sendButton" class="btn btn-primary btn-lg px-5"
                                style="border-radius: 10px; background: linear-gradient(45deg, #4e73df, #224abe); box-shadow: 0 4px 6px rgba(50, 50, 93, 0.11), 0 1px 3px rgba(0, 0, 0, 0.08);">
                                <i class="fas fa-utensils me-1"></i> Find Foods
                            </button>
                        </div>

                        <div id="loading" class="text-center my-5" style="display: none;">
                            <div class="spinner-border text-primary" role="status" style="width: 3rem; height: 3rem;">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                            <div class="mt-3 text-primary fw-bold">Finding suitable menu items...</div>
                        </div>

                        <div id="responseContainer" class="mt-5" style="display: none;">
                            <div class="d-flex align-items-center mb-3">
                                <h5 class="mb-0 me-auto"><i class="fas fa-utensils me-2 text-primary"></i>Recommended Foods
                                </h5>
                                <button id="copyButton" class="btn btn-sm btn-outline-primary" style="border-radius: 8px;">
                                    <i class="fas fa-copy me-1"></i> Copy
                                </button>
                            </div>
                            <div id="responseContent" class="p-4 bg-white rounded-lg border shadow-sm"
                                style="max-height: 500px; overflow-y: auto; border-radius: 15px;"></div>
                        </div>

                        <div id="errorContainer" class="mt-4 alert alert-danger"
                            style="display: none; border-radius: 10px;">
                            <i class="fas fa-exclamation-triangle me-2"></i>
                            <span id="errorMessage"></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const sendButton = document.getElementById('sendButton');
            const clearButton = document.getElementById('clearButton');
            const copyButton = document.getElementById('copyButton');
            const allergiesSelect = document.getElementById('allergies');
            const loadingIndicator = document.getElementById('loading');
            const responseContainer = document.getElementById('responseContainer');
            const responseContent = document.getElementById('responseContent');
            const errorContainer = document.getElementById('errorContainer');
            const errorMessage = document.getElementById('errorMessage');

            // Helper function to show/hide elements properly
            function showElement(element) {
                element.style.display = '';
            }

            function hideElement(element) {
                element.style.display = 'none';
            }

            // Clear button functionality
            clearButton.addEventListener('click', function() {
                // Deselect all options
                for (let i = 0; i < allergiesSelect.options.length; i++) {
                    allergiesSelect.options[i].selected = false;
                }
                hideElement(responseContainer);
                hideElement(errorContainer);
                allergiesSelect.focus();
            });

            // Copy button functionality
            copyButton.addEventListener('click', function() {
                const textToCopy = responseContent.textContent;
                navigator.clipboard.writeText(textToCopy).then(
                    function() {
                        // Temporarily change button text to indicate success
                        const originalText = copyButton.innerHTML;
                        copyButton.innerHTML = '<i class="fas fa-check me-1"></i> Copied!';
                        setTimeout(() => {
                            copyButton.innerHTML = originalText;
                        }, 2000);
                    }
                ).catch(function(err) {
                    console.error('Could not copy text: ', err);
                });
            });

            // Send button functionality
            sendButton.addEventListener('click', async function() {
                // Get selected allergies
                const selectedAllergies = Array.from(allergiesSelect.selectedOptions).map(option =>
                    option.text);

                if (selectedAllergies.length === 0) {
                    errorMessage.textContent = 'Please select at least one allergy';
                    showElement(errorContainer);
                    return;
                }

                // Create prompt for the AI
                const prompt = `Based on the following allergies: ${selectedAllergies.join(', ')},
                    please recommend suitable items from our menu.
                    For each recommended item, explain why it's suitable for someone with these allergies.
                    Format your response with clear headings and bullet points.`;

                // Reset UI
                hideElement(errorContainer);
                hideElement(responseContainer);
                showElement(loadingIndicator);
                sendButton.disabled = true;

                try {
                    const response = await fetch('{{ route('allergies.send') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            prompt
                        })
                    });

                    const data = await response.json();

                    if (response.ok) {
                        // Format and display the response
                        if (data.choices && data.choices.length > 0) {
                            let content;

                            // Handle different response formats
                            if (data.choices[0].message && data.choices[0].message.content) {
                                content = data.choices[0].message.content;
                            } else if (data.choices[0].text) {
                                content = data.choices[0].text;
                            } else {
                                content = JSON.stringify(data.choices[0]);
                            }

                            // Format the response with proper line breaks and styling
                            responseContent.innerHTML = formatResponse(content);
                        } else {
                            // Show the full response for debugging
                            responseContent.innerHTML =
                                '<div class="alert alert-info">Raw API Response:</div>' +
                                '<pre class="mb-0">' + JSON.stringify(data, null, 2) + '</pre>';
                        }
                        showElement(responseContainer);

                        // Scroll to response
                        responseContainer.scrollIntoView({
                            behavior: 'smooth',
                            block: 'start'
                        });
                    } else {
                        // Display detailed error
                        let errorText = data.error || 'An error occurred';
                        if (data.message) {
                            errorText += '<br><small>Message: ' + data.message + '</small>';
                        }
                        errorMessage.innerHTML = errorText;
                        showElement(errorContainer);
                    }
                } catch (error) {
                    errorMessage.innerHTML = 'Failed to send request: ' + error.message;
                    showElement(errorContainer);
                } finally {
                    hideElement(loadingIndicator);
                    sendButton.disabled = false;
                }
            });

            // Function to format the response with proper styling
            function formatResponse(text) {
                // Basic markdown-like formatting
                let formatted = text
                    .replace(/\n/g, '<br>')
                    // Code blocks
                    .replace(/```([a-z]*)\n([\s\S]*?)\n```/g,
                        '<pre class="bg-dark text-light p-3 rounded"><code>$2</code></pre>')
                    // Inline code
                    .replace(/`([^`]+)`/g, '<code class="bg-secondary bg-opacity-25 px-1 rounded">$1</code>')
                    // Bold
                    .replace(/\*\*(.*?)\*\*/g, '<strong>$1</strong>')
                    // Italic
                    .replace(/\*(.*?)\*/g, '<em>$1</em>')
                    // Headers
                    .replace(/^# (.*?)$/gm, '<h3>$1</h3>')
                    .replace(/^## (.*?)$/gm, '<h4>$1</h4>')
                    .replace(/^### (.*?)$/gm, '<h5>$1</h5>')
                    // Lists
                    .replace(/^- (.*?)$/gm, '• $1<br>')
                    .replace(/^\d+\. (.*?)$/gm, '<span class="fw-bold">$&</span><br>');

                return formatted;
            }
        });
    </script>
@endsection
