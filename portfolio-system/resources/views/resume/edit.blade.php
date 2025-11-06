<x-authed-layout>
    <x-slot name="title">Edit Resume</x-slot>

    {{-- Session/Error messages --}}
    @if (session('status'))
        <div class="session-status" style="max-width: 1200px; margin: 20px auto 0;">
            {{ session('status') }}
        </div>
    @endif
    @if ($errors->any())
         <div class="validation-errors" style="max-width: 1200px; margin: 20px auto 0;">
            <strong>Please correct the errors:</strong>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
         </div>
    @endif
    
    {{-- This form uses your .resume-layout class --}}
<form method="POST" action="{{ route('resume.update') }}" class="resume-layout" id="resume-form" enctype="multipart/form-data">
    @csrf
        
        {{-- Left Sidebar (Personal Details) --}}
<div class="resume-left">
    <h2 class="sidebar-title">Personal Details</h3>
    
    <div class="form-group profile-pic-upload-container" style="position: relative; text-align: center; margin-bottom: 20px;">
    <label for="profile_picture" class="profile-pic" 
           id="profile-pic-preview"
           style="
               background-color: #ccc; 
               /* Add the image check here: */
               @if($resume->profile_picture_path) 
                   background-image: url('{{ asset('storage/' . $resume->profile_picture_path) }}'); 
                   background-size: cover; background-position: center;
               @endif 
               display: flex; align-items: center; justify-content: center; 
               font-size: 12px; color: #666; text-align: center; padding: 10px; 
               border-radius: 50%; width: 100px; height: 100px; margin: 0 auto 10px; cursor: pointer;
           ">
        {{-- Display upload text only if no picture exists --}}
        @if(!$resume->profile_picture_path)
            (Profile Picture Upload)
        @endif
    </label>
    
    <input type="file" id="profile_picture" name="profile_picture" accept="image/*" style="display: none;">
    @error('profile_picture') <div class='error-msg'>{{ $message }}</div> @enderror
</div>
    
    <div class="form-group">
        <label for="name">Full Name</label>
        <input type="text" id="name" name="name" value="{{ old('name', $resume->name) }}">
        @error('name') <div class='error-msg'>{{ $message }}</div> @enderror
    </div>
            
            <div class="form-group">
                <label for="title">Title / Designation</label>
                <input type="text" id="title" name="title" value="{{ old('title', $resume->title) }}">
                @error('title') <div class='error-msg'>{{ $message }}</div> @enderror
            </div>

            <div class="form-group">
                <label for="address">Address</label>
                <input type="text" id="address" name="address" value="{{ old('address', $resume->address) }}">
                @error('address') <div class='error-msg'>{{ $message }}</div> @enderror
            </div>
            
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" value="{{ old('email', $resume->email) }}">
                @error('email') <div class='error-msg'>{{ $message }}</div> @enderror
            </div>
            
            <div class="form-group">
                <label for="phone">Phone</label>
                <input type="text" id="phone" name="phone" value="{{ old('phone', $resume->phone) }}">
                @error('phone') <div class='error-msg'>{{ $message }}</div> @enderror
            </div>
            
            <div class="form-group">
                <label for="github_link">GitHub Link</label>
                <input type="url" id="github_link" name="github_link" value="{{ old('github_link', $resume->github_link) }}">
                @error('github_link') <div class='error-msg'>{{ $message }}</div> @enderror
            </div>
            
            <div class="form-group">
                <label for="linkedin_link">LinkedIn Link</label>
                <input type="url" id="linkedin_link" name="linkedin_link" value="{{ old('linkedin_link', $resume->linkedin_link) }}">
                @error('linkedin_link') <div class='error-msg'>{{ $message }}</div> @enderror
            </div>
        </div> {{-- End .resume-left --}}

        {{-- Right Content Area --}}
        <div class="resume-right">
            <div class="main-content">
                {{-- Profile Summary (Still a textarea) --}}
                <h2 class="section-title-style">Profile Summary</h2>
                <div class="form-group full-width">
                    <textarea id="profile_summary" name="profile_summary">{{ old('profile_summary', $resume->profile_summary) }}</textarea>
                    @error('profile_summary') <div class='error-msg'>{{ $message }}</div> @enderror
                </div>

                {{-- Skills Dropbox --}}
                <details class="dynamic-section" open>
                    <summary class="section-title-style accordion-title">Skills</summary>
                    <div class="dynamic-container" id="skills-container">
                        {{-- Skills will be dynamically added here by JavaScript --}}
                    </div>
                    <button type="button" class="btn-add-item" id="add-skill-btn">+ Add Skill</button>
                </details>

                {{-- Education Dropbox --}}
                <details class="dynamic-section" open>
                    <summary class="section-title-style accordion-title">Education</summary>
                    <div class="dynamic-container" id="education-container">
                        {{-- Education will be dynamically added here --}}
                    </div>
                    <button type="button" class="btn-add-item" id="add-education-btn">+ Add Education</button>
                </details>

                {{-- Work Experience Dropbox --}}
                <details class="dynamic-section" open>
                    <summary class="section-title-style accordion-title">Work Experience / Projects</summary>
                    <div class="dynamic-container" id="works-container">
                        {{-- Works will be dynamically added here --}}
                    </div>
                    <button type="button" class="btn-add-item" id="add-work-btn">+ Add Work</button>
                </details>

                {{-- Organizations Dropbox --}}
                <details class="dynamic-section" open>
                    <summary class="section-title-style accordion-title">Organizations</summary>
                    <div class="dynamic-container" id="organizations-container">
                        {{-- Organizations will be dynamically added here --}}
                    </div>
                    <button type="button" class="btn-add-item" id="add-organization-btn">+ Add Organization</button>
                </details>

                {{-- Save Button --}}
                <div class="form-group" style="text-align: right; margin-top: 30px;">
                    <button type="submit" class="submit-btn">Save All Changes</button>
                </div>
            </div> {{-- End .main-content --}}
        </div> {{-- End .resume-right --}}

        {{-- HIDDEN TEXTAREAS --}}
        {{-- These are now hidden. JavaScript will use them to load and save data. --}}
        <div style="display: none;">
            <textarea id="skills_list" name="skills_list">{{ old('skills_list', json_encode($resume->skills_list ?? [], JSON_PRETTY_PRINT)) }}</textarea>
            <textarea id="education" name="education">{{ old('education', json_encode($resume->education ?? [], JSON_PRETTY_PRINT)) }}</textarea>
            <textarea id="works" name="works">{{ old('works', json_encode($resume->works ?? [], JSON_PRETTY_PRINT)) }}</textarea>
            <textarea id="organizations" name="organizations">{{ old('organizations', json_encode($resume->organizations ?? [], JSON_PRETTY_PRINT)) }}</textarea>
        </div>
    </form> {{-- End .resume-layout --}}

    <template id="skill-template">
        <div class="dynamic-item-card">
            <button type="button" class="btn-remove-item">&times;</button>
            <div class="form-group">
                <label>Skill Name (e.g., PHP, Java, Python)</label>
                <input type="text" class="dynamic-input" data-key="name">
            </div>
            <div class="form-group">
                <label>Level (<span class="slider-value">50%</span>)</label>
                <input type="range" min="0" max="100" value="50" class="dynamic-input dynamic-slider" data-key="level">
            </div>
        </div>
    </template>

    <template id="education-template">
        <div class="dynamic-item-card">
            <button type="button" class="btn-remove-item">&times;</button>
            <div class="form-group">
                <label>Degree (e.g., BS in Computer Science)</label>
                <input type="text" class="dynamic-input" data-key="degree">
            </div>
            <div class="form-group">
                <label>School (e.g., Batangas State University)</label>
                <input type="text" class="dynamic-input" data-key="school">
            </div>
            <div class="form-group">
                <label>Dates (Start Month - End Month / "Present")</label>
                <div class="date-range">
                    <input type="month" class="dynamic-input" data-key="start_date">
                    <span>to</span>
                    <input type="month" class="dynamic-input" data-key="end_date">
                </div>
            </div>
        </div>
    </template>

    <template id="work-template">
        <div class="dynamic-item-card">
            <button type="button" class="btn-remove-item">&times;</button>
            <div class="form-group">
                <label>Title (e.g., Web Developer, Project Name)</label>
                <input type="text" class="dynamic-input" data-key="title">
            </div>
            <div class="form-group">
                <label>Description</label>
                <textarea class="dynamic-input" data-key="description"></textarea>
            </div>
            <div class="form-group">
                <label>Link (Must be a valid URL)</label>
                <input type="url" class="dynamic-input" data-key="link" placeholder="https://...">
            </div>
        </div>
    </template>

    <template id="organization-template">
        <div class="dynamic-item-card">
            <button type="button" class="btn-remove-item">&times;</button>
            <div class="form-group">
                <label>Organization Name (e.g., JPCS)</label>
                <input type="text" class="dynamic-input" data-key="name">
            </div>
            <div class="form-group">
                <label>Role (e.g., Assistant Secretary)</label>
                <input type="text" class="dynamic-input" data-key="role">
            </div>
            <div class="form-group">
                <label>Dates (Start Month - End Month / "Present")</label>
                <div class="date-range">
                    <input type="month" class="dynamic-input" data-key="start_date">
                    <span>to</span>
                    <input type="month" class="dynamic-input" data-key="end_date">
                </div>
            </div>
        </div>
    </template>
    
    <script>
    document.addEventListener('DOMContentLoaded', () => {

    const profilePicInput = document.getElementById('profile_picture');
    const profilePicPreview = document.getElementById('profile-pic-preview');

    if (profilePicInput && profilePicPreview) {
        profilePicInput.addEventListener('change', function(event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    profilePicPreview.style.backgroundImage = `url(${e.target.result})`;
                    profilePicPreview.textContent = ''; // Remove the "(Profile Picture Upload)" text
                };
                reader.readAsDataURL(file);
            } else {
                profilePicPreview.style.backgroundImage = 'none';
                profilePicPreview.textContent = '(Profile Picture Upload)'; // Restore text if no file selected
            }
        });
        function createItemCard(templateId, data = {}) {
            const template = document.getElementById(templateId);
            if (!template) {
                console.error(`Template with ID ${templateId} not found.`);
                return null;
            }

            const card = template.content.firstElementChild.cloneNode(true);

            // Populate all inputs, selects, and textareas
            card.querySelectorAll('.dynamic-input').forEach(input => {
                const key = input.dataset.key;
                if (data[key] !== undefined) {
                    input.value = data[key];
                }
            });

            // --- Special Handler: Skill Slider ---
            if (templateId === 'skill-template') {
                const slider = card.querySelector('.dynamic-slider');
                const valueSpan = card.querySelector('.slider-value');
                
                if (slider && valueSpan) {
                    // Set initial text from data or default
                    valueSpan.textContent = `${slider.value}%`; 
                    
                    // Add listener to update text on change
                    slider.addEventListener('input', () => {
                        valueSpan.textContent = `${slider.value}%`;
                    });
                }
            }
            
            return card;
        }

        /**
         * -----------------------------------------------------------------
         * Helper Function: Load initial data from textareas into the UI
         * -----------------------------------------------------------------
         */
        function loadInitialData(containerId, templateId, textareaId) {
            const container = document.getElementById(containerId);
            const textarea = document.getElementById(textareaId);
            
            if (!container || !textarea) return;

            let data = [];
            try {
                // Load data from the textarea, fallback to empty array if invalid
                if (textarea.value) {
                    data = JSON.parse(textarea.value);
                }
            } catch (e) {
                console.error(`Error parsing JSON from #${textareaId}:`, e.value, e);
                data = [];
            }

            if (Array.isArray(data)) {
                container.innerHTML = ''; // Clear any existing
                data.forEach(item => {
                    const card = createItemCard(templateId, item);
                    if (card) container.appendChild(card);
                });
            }
        }

        /**
         * -----------------------------------------------------------------
         * Helper Function: Sync UI data back to its hidden textarea
         * -----------------------------------------------------------------
         */
        function syncDataToTextarea(containerId, textareaId) {
            const container = document.getElementById(containerId);
            const textarea = document.getElementById(textareaId);
            if (!container || !textarea) return;

            const cards = container.querySelectorAll('.dynamic-item-card');
            const data = [];

            cards.forEach(card => {
                const item = {};
                // Find all inputs and save their key/value pairs
                card.querySelectorAll('.dynamic-input').forEach(input => {
                    item[input.dataset.key] = input.value;
                });
                data.push(item);
            });

            // Stringify the data and put it back in the textarea for submission
            textarea.value = JSON.stringify(data, null, 2);
        }

        // --- End Helper Functions ---


        /**
         * -----------------------------------------------------------------
         * Main Setup
         * -----------------------------------------------------------------
         */

        // Configuration for all dynamic sections
        const sections = [
            {
                container: 'skills-container',
                template: 'skill-template',
                addBtn: 'add-skill-btn',
                textarea: 'skills_list'
            },
            {
                container: 'education-container',
                template: 'education-template',
                addBtn: 'add-education-btn',
                textarea: 'education'
            },
            {
                container: 'works-container',
                template: 'work-template',
                addBtn: 'add-work-btn',
                textarea: 'works'
            },
            {
                container: 'organizations-container',
                template: 'organization-template',
                addBtn: 'add-organization-btn',
                textarea: 'organizations'
            }
        ];

        // Loop over each section to initialize it
        sections.forEach(sec => {
            const container = document.getElementById(sec.container);
            const addBtn = document.getElementById(sec.addBtn);

            if (!container || !addBtn) {
                console.warn(`Could not find elements for section: ${sec.container}`);
                return;
            }

            // 1. Load initial data on page load
            loadInitialData(sec.container, sec.template, sec.textarea);

            // 2. Setup "Add" button
            addBtn.addEventListener('click', () => {
                const card = createItemCard(sec.template);
                if (card) container.appendChild(card);
            });

            // 3. Setup "Remove" button (using event delegation)
            container.addEventListener('click', (e) => {
                if (e.target.classList.contains('btn-remove-item')) {
                    // Find the closest card and remove it
                    e.target.closest('.dynamic-item-card').remove();
                }
            });
        });

        const form = document.getElementById('resume-form');
        if (form) {
            form.addEventListener('submit', () => {
                // Sync all sections before the form actually submits
                sections.forEach(sec => {
                    syncDataToTextarea(sec.container, sec.textarea);
                });
                // The form will now submit with the updated textarea values
            });
        }
    }});
    </script>
</x-authed-layout>