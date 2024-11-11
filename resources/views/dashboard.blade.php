<x-app-layout>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <!-- resources/views/dashboard.blade.php -->

                    <div class="flex justify-center bg-gray-800 text-white py-4">
                        <button onclick="showTab('categories')"
                            class="px-4 py-2 mx-2 rounded-md bg-blue-600 hover:bg-blue-700">Categories</button>
                        <button onclick="showTab('images')"
                            class="px-4 py-2 mx-2 rounded-md bg-blue-600 hover:bg-blue-700">Images</button>
                        <button onclick="showTab('events')"
                            class="px-4 py-2 mx-2 rounded-md bg-blue-600 hover:bg-blue-700">Events</button>
                    </div>

                    <div class="p-6">
                        <!-- Categories Section -->
                        <div id="categories" class="tab-content hidden">
                            <!-- Content for categories (e.g., form, list, etc.) -->
                            <div class="container mx-auto px-4">

                                <div class="flex justify-between items-center mb-4">
                                    <h2 class="text-2xl font-semibold">Categories</h2>
                                    <button onclick="createCategory()"
                                        class="bg-green-600 text-white px-4 py-2 rounded-md shadow hover:bg-green-700">
                                        Create New Category
                                    </button>
                                </div>

                                <!-- Dropdown and edit form -->
                                <div class="mb-6 bg-white dark:bg-gray-800 p-4 rounded-lg shadow-md">
                                    <h2 class="text-lg font-semibold mb-2 text-gray-800 dark:text-gray-200">Edit
                                        Category</h2>
                                    <form id="edit-category-form" class="space-y-4">
                                        @csrf
                                        <div>
                                            <label for="category-select"
                                                class="block text-gray-600 dark:text-gray-400">Select Category:</label>
                                            <select id="category-select" name="id"
                                                class="w-full p-2 border border-gray-300 rounded-md dark:bg-gray-700 dark:text-gray-300">
                                                <option value="">Select a category</option>
                                                @foreach($categories as $category)
                                                    <option value="{{ $category->id }}" data-name="{{ $category->name }}"
                                                        data-colour="{{ $category->colour }}">
                                                        {{ $category->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div>
                                            <label for="name"
                                                class="block text-gray-600 dark:text-gray-400">Name:</label>
                                            <input type="text" id="name" name="name"
                                                class="w-full p-2 border border-gray-300 rounded-md dark:bg-gray-700 dark:text-gray-300">
                                        </div>
                                        <div>
                                            <label for="colour" class="block text-gray-600 dark:text-gray-400">Colour
                                                (RGB or Hex):</label>
                                            <div class="flex items-center">
                                                <input type="text" id="colour" name="colour"
                                                    class="w-full p-2 border border-gray-300 rounded-md dark:bg-gray-700 dark:text-gray-300 mr-4">
                                                <div id="colour-preview"
                                                    style="width: 24px; height: 24px; border: 1px solid #ccc; border-radius: 4px;">
                                                </div>
                                            </div>
                                        </div>
                                        <button type="button" id="save-button"
                                            class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-md">Save</button>
                                    </form>
                                </div>
                            </div>


                            <!-- Table displaying categories -->
                            <div class="overflow-x-auto">
                                <table
                                    class="min-w-full bg-white dark:bg-gray-700 shadow-md rounded-lg overflow-hidden">
                                    <thead>
                                        <tr
                                            class="bg-gray-200 dark:bg-gray-600 text-gray-800 dark:text-gray-100 uppercase text-sm leading-normal">
                                            <th class="py-3 px-6 text-center">ID</th>
                                            <th class="py-3 px-6 text-center">Name</th>
                                            <th class="py-3 px-6 text-center">Colour</th>
                                            <th class="py-3 px-6 text-center">Colour Preview</th>
                                            <th class="py-3 px-6 text-center">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody class="text-gray-700 dark:text-gray-200 text-sm">
                                        @foreach($categories as $category)
                                            <tr
                                                class="border-b border-gray-200 dark:border-gray-600 hover:bg-gray-100 dark:hover:bg-gray-600">
                                                <td class="py-3 px-6 text-center">{{ $category->id }}</td>
                                                <td class="py-3 px-6 text-center">{{ $category->name }}</td>
                                                <td class="py-3 px-6 text-center">{{ $category->colour }}</td>
                                                <td class="py-3 px-6 text-center">
                                                    <div
                                                        style="width: 20px; height: 20px; background-color: {{ $category->colour }}; border: 1px solid #ccc; border-radius: 4px; display: inline-block;">
                                                    </div>
                                                </td>
                                                <td class="py-3 px-6 text-center">
                                                    <button onclick="deleteCategory({{ $category->id }})"
                                                        class="text-red-500 hover:text-red-700">Delete</button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                        </div>

                        <!-- Images Section -->
                        <div id="images" class="tab-content hidden">
                            <h2 class="text-2xl font-semibold mb-4">Images</h2>




                            <!-- Update Form for Selected Image -->
                            <div id="imageEditForm"
                                class="hidden p-4 mb-4 bg-gray-100 dark:bg-gray-800 rounded-lg shadow-md">
                                <h2 class="text-lg font-semibold text-center">Edit Image Details</h2>
                                <form id="editImageForm" method="POST" action="">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" id="imageId" name="image_id">

                                    <div class="mb-4">
                                        <label for="imageName"
                                            class="block text-sm font-medium text-gray-600 dark:text-gray-300">Name</label>
                                        <input type="text" id="imageName" name="name"
                                            class="mt-1 block w-full rounded-md border border-gray-400 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 shadow-sm focus:border-blue-600 focus:ring focus:ring-blue-500 focus:ring-opacity-50"
                                            required>
                                    </div>

                                    <div class="mb-4">
                                        <label for="imageDescription"
                                            class="block text-sm font-medium text-gray-600 dark:text-gray-300">Description</label>
                                        <textarea id="imageDescription" name="description"
                                            class="mt-1 block w-full rounded-md border border-gray-400 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 shadow-sm focus:border-blue-600 focus:ring focus:ring-blue-500 focus:ring-opacity-50"
                                            rows="3"></textarea>
                                    </div>

                                    <button type="submit"
                                        class="px-4 py-2 bg-blue-600 text-white rounded-md shadow hover:bg-blue-700">Update</button>
                                </form>

                            </div>

                            <!-- Image List -->
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                @foreach($images as $image)
                                    <div class="p-4 bg-gray-100 dark:bg-gray-800 shadow-md rounded-lg cursor-pointer border border-gray-300 dark:border-gray-700"
                                        onclick="editImage({{ $image->id }}, '{{ $image->name }}', '{{ $image->description }}', '{{ asset($image->path) }}')">
                                        <img src="{{ asset($image->path) }}" alt="{{ $image->name }}"
                                            class="w-full h-48 object-cover rounded">
                                        <h3 id="imageNameDisplay-{{ $image->id }}"
                                            class="mt-2 text-center text-lg font-semibold text-gray-700 dark:text-gray-300">
                                            {{ $image->name }}
                                        </h3>
                                        <p id="imageDescriptionDisplay-{{ $image->id }}"
                                            class="text-gray-600 dark:text-gray-400 text-center">
                                            {{ $image->description }}
                                        </p>
                                    </div>
                                @endforeach
                            </div>


                        </div>
                        <!-- Events Section -->
                        <div id="events" class="tab-content hidden">
                            <h2 class="text-2xl font-semibold mb-4">Events</h2>

                            <!-- Event Creation Form -->
                            <div id="createEventForm"
                                class="mb-6 p-4 bg-gray-100 dark:bg-gray-800 rounded-lg shadow-md">
                                <h3 class="text-lg font-semibold text-center text-gray-800 dark:text-gray-200">Create
                                    New Event</h3>
                                <form id="eventCreationForm">
                                    @csrf
                                    <div class="mb-4">
                                        <label for="eventName"
                                            class="block text-sm font-medium text-gray-600 dark:text-gray-400">Name</label>
                                        <input type="text" id="eventName" name="name"
                                            class="w-full p-2 border border-gray-300 rounded-md dark:bg-gray-700 dark:text-gray-300"
                                            required>
                                    </div>

                                    <div class="mb-4">
                                        <label for="eventCategory"
                                            class="block text-sm font-medium text-gray-600 dark:text-gray-400">Category</label>
                                        <select id="eventCategory" name="category_id"
                                            class="w-full p-2 border border-gray-300 rounded-md dark:bg-gray-700 dark:text-gray-300"
                                            required>
                                            <option value="">Select a Category</option>
                                            @foreach($categories as $category)
                                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="mb-4">
                                        <label for="eventDescription"
                                            class="block text-sm font-medium text-gray-600 dark:text-gray-400">Description</label>
                                        <textarea id="eventDescription" name="description"
                                            class="w-full p-2 border border-gray-300 rounded-md dark:bg-gray-700 dark:text-gray-300"
                                            rows="3"></textarea>
                                    </div>

                                    <div class="mb-4">
                                        <label for="beginDate"
                                            class="block text-sm font-medium text-gray-600 dark:text-gray-400">Begin
                                            Date</label>
                                        <input type="date" id="beginDate" name="begin_date"
                                            class="w-full p-2 border border-gray-300 rounded-md dark:bg-gray-700 dark:text-gray-300"
                                            required>
                                    </div>

                                    <div class="mb-4">
                                        <label for="endDate"
                                            class="block text-sm font-medium text-gray-600 dark:text-gray-400">End
                                            Date</label>
                                        <input type="date" id="endDate" name="end_date"
                                            class="w-full p-2 border border-gray-300 rounded-md dark:bg-gray-700 dark:text-gray-300"
                                            required>
                                    </div>
                                    <div class="mb-4">
                                        <label for="eventImage"
                                            class="block text-sm font-medium text-gray-600 dark:text-gray-400">Image</label>
                                        <select id="eventImage" name="image_id"
                                            class="w-full p-2 border border-gray-300 rounded-md dark:bg-gray-700 dark:text-gray-300 text-gray-800">
                                            <option value="">No Image</option>
                                            @foreach($images as $image)
                                                <option value="{{ $image->id }}">{{ $image->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <button type="button" onclick="submitNewEvent()"
                                        class="w-full px-4 py-2 bg-blue-500 text-white font-bold rounded-md hover:bg-blue-700 shadow">
                                        Create Event
                                    </button>
                                </form>
                            </div>

                            <div class="p-6 bg-white dark:bg-gray-800 shadow-md rounded-lg">
                                <!-- Event List Table -->
                                <div class="overflow-x-auto">
                                    <table class="min-w-full bg-white dark:bg-gray-700 shadow-md rounded-lg">
                                        <thead>
                                            <tr
                                                class="bg-gray-200 dark:bg-gray-600 text-gray-800 dark:text-gray-100 uppercase text-sm leading-normal">
                                                <th class="py-3 px-6 text-center">ID</th>
                                                <th class="py-3 px-6 text-center">Name</th>
                                                <th class="py-3 px-6 text-center">Category</th>
                                                <th class="py-3 px-6 text-center">Description</th>
                                                <th class="py-3 px-6 text-center">Begin Date</th>
                                                <th class="py-3 px-6 text-center">End Date</th>
                                                <th class="py-3 px-6 text-center">Image</th>
                                                <th class="py-3 px-6 text-center">Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody class="text-gray-700 dark:text-gray-200 text-sm">
                                            @foreach ($events as $event)
                                                <tr
                                                    class="border-b border-gray-200 dark:border-gray-600 hover:bg-gray-100 dark:hover:bg-gray-600">
                                                    <td class="py-3 px-6 text-center">{{ $event->id }}</td>
                                                    <td class="py-3 px-6 text-center">{{ $event->name }}</td>
                                                    <td class="py-3 px-6 text-center">{{ $event->category->name ?? 'N/A' }}
                                                    </td>
                                                    <td class="py-3 px-6 truncate max-w-xs text-center">
                                                        {{ $event->description }}
                                                    </td>
                                                    <td class="py-3 px-6 text-center">{{ $event->begin_date }}</td>
                                                    <td class="py-3 px-6 text-center">{{ $event->end_date }}</td>
                                                    <td class="py-3 px-6 text-center">
                                                        @if ($event->image)
                                                            <img src="{{ asset($event->image->path) }}"
                                                                alt="{{ $event->image->name }}"
                                                                class="w-16 h-16 object-cover rounded">
                                                        @else
                                                            <span class="text-gray-500 dark:text-gray-400">N/A</span>
                                                        @endif
                                                    </td>
                                                    <td class="py-3 px-6 text-center">
                                                        <button onclick="deleteEvent({{ $event->id }})"
                                                            class="text-red-500 hover:text-red-700">Delete</button>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
</x-app-layout>

<script>

    document.addEventListener('DOMContentLoaded', function () {
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        const categorySelect = document.getElementById('category-select');
        const nameInput = document.getElementById('name');
        const colourInput = document.getElementById('colour');
        const colourPreview = document.getElementById('colour-preview');
        const saveButton = document.getElementById('save-button');

        function updateColourPreview() {
            colourPreview.style.backgroundColor = colourInput.value || '#ffffff';
        }

        function isValidColour(colour) {
            const rgbRegex = /^#([A-Fa-f0-9]{6})$/;
            return rgbRegex.test(colour);
        }

        updateColourPreview();

        colourInput.addEventListener('input', updateColourPreview);

        categorySelect.addEventListener('change', function () {
            const selectedOption = categorySelect.options[categorySelect.selectedIndex];
            nameInput.value = selectedOption.getAttribute('data-name') || '';
            colourInput.value = selectedOption.getAttribute('data-colour') || '';
            updateColourPreview();
        });

        saveButton.addEventListener('click', function () {
            const categoryId = categorySelect.value;
            const name = nameInput.value;
            const colour = colourInput.value;

            if (!isValidColour(colour)) {
                alert("Please enter a valid RGB colour code in the format #FFFFFF.");
                return;
            }

            if (!categoryId) {
                alert("Please select a category to edit.");
                return;
            }

            fetch(`/categories/update/${categoryId}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                },
                body: JSON.stringify({ name: name, colour: colour })
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert("Category updated successfully!");
                        location.reload();
                    } else {
                        alert("Failed to update category.");
                    }
                })
                .catch(error => console.error('Error:', error));
        });
    });

    function showTab(tabId) {

        document.querySelectorAll('.tab-content').forEach(tab => {
            tab.classList.add('hidden');
        });

        document.getElementById(tabId).classList.remove('hidden');
    }

    document.addEventListener('DOMContentLoaded', function () {
        showTab('categories');
    });

    async function deleteCategory(categoryId) {

        if (!confirm("Are you sure you want to delete this category?")) return;

        try {
            const response = await fetch(`/categories/${categoryId}`, {
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                },
            });

            const result = await response.json();

            if (result.success) {
                alert("Category deleted successfully.");
                location.reload();
            } else {
                alert(result.message);
            }
        } catch (error) {
            console.error("Error deleting category:", error);
            alert("An error occurred while trying to delete the category.");
        }
    }

    async function createCategory() {
        try {
            const response = await fetch('/categories', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                },
                body: JSON.stringify({
                    name: 'New Category',
                    colour: '#FFFFFF'
                }),
            });

            console.log('Response status:', response.status);
            const result = await response.json();
            console.log('Response JSON:', result);

            if (response.ok && result.success) {
                alert("New category created successfully.");
                location.reload(); 
            } else {
                console.warn('Response not OK or success not true:', result);
                alert("Failed to create category.");
            }
        } catch (error) {
            console.error("Error creating category:", error);
            alert("An error occurred while trying to create a new category.");
        }
    }

    function editImage(id, name, description, imagePath) {
        document.getElementById('imageEditForm').classList.remove('hidden');
        document.getElementById('imageId').value = id;
        document.getElementById('imageName').value = name;
        document.getElementById('imageDescription').value = description;
        document.getElementById('editImageForm').action = `/images/update/${id}`;
    }


    document.getElementById('editImageForm').addEventListener('submit', async function (event) {
        event.preventDefault(); 

        const id = document.getElementById('imageId').value;
        const name = document.getElementById('imageName').value;
        const description = document.getElementById('imageDescription').value;

        try {
            const response = await fetch(`/images/update/${id}`, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ name, description })
            });

            const result = await response.json();

            if (result.success) {

                document.getElementById(`imageNameDisplay-${id}`).textContent = name;
                document.getElementById(`imageDescriptionDisplay-${id}`).textContent = description;


                document.getElementById('imageEditForm').classList.add('hidden');
                alert("Image updated successfully."); 
            } else {
                alert("Failed to update image. Please try again.");
            }
        } catch (error) {
            console.error("Error updating image:", error);
            alert("An error occurred while updating the image.");
        }
    });

    document.addEventListener('DOMContentLoaded', function () {
        showTab('categories');
    });

    let isSubmitting = false;

    async function submitNewEvent() {
        if (isSubmitting) return;
        isSubmitting = true;

        const formData = {
            name: document.getElementById('eventName').value,
            category_id: document.getElementById('eventCategory').value,
            description: document.getElementById('eventDescription').value,
            begin_date: document.getElementById('beginDate').value,
            end_date: document.getElementById('endDate').value,
            image_id: document.getElementById('eventImage').value,
            _token: '{{ csrf_token() }}'
        };

        try {
            const response = await fetch('{{ route("events.store") }}', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify(formData)
            });

            if (!response.ok) {
                throw new Error("Network response was not ok " + response.statusText);
            }

            const result = await response.json();

            if (result.success && result.data && result.data.id) {
                alert('Event created successfully.');
                document.getElementById('eventCreationForm').reset();
                showTab('events');

                const newEventRow = document.createElement('tr');
                newEventRow.classList.add('border-b', 'border-gray-200', 'hover:bg-gray-100');

                newEventRow.innerHTML = `
                <td class="py-3 px-6">${result.data.id}</td>
                <td class="py-3 px-6">${formData.name}</td>
                <td class="py-3 px-6">${document.getElementById('eventCategory').selectedOptions[0].text}</td>
                <td class="py-3 px-6 truncate max-w-xs">${formData.description || ''}</td>
                <td class="py-3 px-6">${formData.begin_date}</td>
                <td class="py-3 px-6">${formData.end_date}</td>
                <td class="py-3 px-6">
                    ${formData.image_id ? `<img src="/path/to/image/${formData.image_id}" alt="${formData.name}" class="w-16 h-16 object-cover rounded">` : 'N/A'}
                </td>
                <td class="py-3 px-6 text-center">
                    <button onclick="deleteEvent(${result.data.id})" class="text-red-500 hover:text-red-700">Delete</button>
                </td>
            `;

                document.querySelector('#events table tbody').appendChild(newEventRow);
            } else {
                alert('Failed to create event. Please check data and try again.');
            }
        } catch (error) {
            console.error('Network error occurred:', error);
            alert('A network error occurred. Please try again.');
        } finally {
            isSubmitting = false;
        }
    }

    function displayEvents(events) {
        const eventDetailsDiv = document.getElementById('eventDetails');

        if (events.data.length > 0) {
            eventDetailsDiv.innerHTML = `
            <div class="relative border-l-2 border-gray-400 dark:border-gray-600">
                ${events.data.map((event, index) => `
                    <div class="relative flex items-start mb-10 ml-4 border border-gray-300 dark:border-gray-700 rounded-md p-4 shadow-sm bg-white dark:bg-gray-800 h-48 lg:h-60">
                        <div class="absolute left-[-1.5rem] top-1/2 transform -translate-y-1/2 w-3 h-3 bg-blue-600 rounded-full border border-white dark:border-gray-800"></div>
                        <div class="flex-1 w-2/5 h-full cursor-pointer" onclick="toggleDescription(${index})">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white truncate">${event.name}</h3>
                            <time class="block mb-2 text-sm font-normal leading-none text-gray-400 dark:text-gray-500">
                                ${new Date(event.begin_date).toLocaleDateString()} - ${new Date(event.end_date).toLocaleDateString()}
                            </time>
                            <p id="description-${index}" class="text-base font-normal text-gray-600 dark:text-gray-400 mt-2 hidden">
                                ${event.description}
                            </p>
                        </div>
                        ${event.image && event.image.path ? `
                            <div class="flex-shrink-0 w-3/5 ml-4 h-full">
                                <img src="${window.location.origin}/${event.image.path}" alt="${event.image.name}" class="w-full h-full object-contain rounded-md shadow-md">
                            </div>
                        ` : ''}
                    </div>
                `).join('')}
            </div>
        `;
        } else {
            eventDetailsDiv.innerHTML = `<p class="text-gray-700 dark:text-gray-400">No events to display for the selected categories.</p>`;
        }
    }

    function toggleDescription(index) {
        const descriptionElement = document.getElementById(`description-${index}`);
        descriptionElement.classList.toggle('hidden');
    }

    async function showSelectedCategories() {
        const selected = document.querySelectorAll('input[name="categories[]"]:checked');
        const selectedCategoryIds = Array.from(selected).map(checkbox => checkbox.value);

        if (selectedCategoryIds.length > 0) {
            try {
                const response = await fetch(`/events/by-categories`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ categories: selectedCategoryIds })
                });

                const events = await response.json();
                displayEvents(events);
            } catch (error) {
                console.error('Error fetching events:', error);
            }
        } else {
            displayEvents({ data: [] });
        }
    }

    document.addEventListener("DOMContentLoaded", function () {
        showSelectedCategories();
    });

    async function deleteEvent(eventId) {
        if (!confirm("Are you sure you want to delete this event?")) return;

        try {
            const response = await fetch(`/events/${eventId}`, {
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                },
            });

            const result = await response.json();

            if (result.success) {
                alert("Event deleted successfully.");
                location.reload();
            } else {
                alert("Failed to delete event.");
            }
        } catch (error) {
            console.error("Error deleting event:", error);
            alert("An error occurred while trying to delete the event.");
        }
    }

</script>