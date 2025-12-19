      // ==================== NAVIGATION ====================

// Navigation pour l'espace enseignant
function showSection(sectionId) {
    document.querySelectorAll('.section-content').forEach(section => {
        section.classList.add('hidden');
    });
    document.getElementById(sectionId).classList.remove('hidden');
    
    // Update active nav link
    document.querySelectorAll('nav a').forEach(link => {
        link.classList.remove('border-indigo-500', 'text-gray-900');
        link.classList.add('border-transparent', 'text-gray-500');
    });
    if (event && event.target) {
        event.target.classList.remove('border-transparent', 'text-gray-500');
        event.target.classList.add('border-indigo-500', 'text-gray-900');
    }
}
// Toggle user dropdown
function toggleDropdown() {
    const dropdown = document.getElementById('userDropdown');
    dropdown.classList.toggle('hidden');
}

// Close dropdown when clicking outside
document.addEventListener('click', function(event) {
    const dropdown = document.getElementById('userDropdown');
    const button = event.target.closest('button');
    
    if (!button || !button.onclick || button.onclick.toString().indexOf('toggleDropdown') === -1) {
        if (!dropdown.contains(event.target)) {
            dropdown.classList.add('hidden');
        }
    }
});

// Open modal
function openModal(modalId) {
    const modal = document.getElementById(modalId);
    modal.classList.remove('hidden');
    modal.classList.add('flex');
}
// Close modal
function closeModal(modalId) {
    const modal = document.getElementById(modalId);
    modal.classList.add('hidden');
    modal.classList.remove('flex');
}

    
    // Remove Question from Quiz Creation Form
    function removeQuestion(button) {
        const questionBlock = button.closest('.question-block');
        questionBlock.remove();
        
        // Renumber questions
        const questions = document.querySelectorAll('.question-block');
        questions.forEach((q, index) => {
            const title = q.querySelector('h5');
            title.textContent = `Question ${index + 1}`;
        });
        questionCount = questions.length;
    }

      // Add Question to Quiz Creation Form
function addQuestion() {
    questionCount++;
    const container = document.getElementById('questionsContainer');
    const questionHTML = `
        <div class="bg-gray-50 rounded-lg p-4 mb-4 question-block">
            <div class="flex justify-between items-center mb-4">
                <h5 class="font-bold text-gray-900">Question ${questionCount}</h5>
                <button type="button" onclick="removeQuestion(this)" class="text-red-600 hover:text-red-700">
                    <i class="fas fa-trash"></i>
                </button>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2">Question *</label>
                <input type="text" name="questions[${questionCount-1}][question]" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent" placeholder="Posez votre question...">
            </div>

            <div class="grid md:grid-cols-2 gap-3 mb-3">
                <div>
                    <label class="block text-gray-700 text-sm mb-2">Option 1 *</label>
                    <input type="text" name="questions[${questionCount-1}][option1]" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                </div>
                <div>
                    <label class="block text-gray-700 text-sm mb-2">Option 2 *</label>
                    <input type="text" name="questions[${questionCount-1}][option2]" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                </div>
                <div>
                    <label class="block text-gray-700 text-sm mb-2">Option 3 *</label>
                    <input type="text" name="questions[${questionCount-1}][option3]" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                </div>
                <div>
                    <label class="block text-gray-700 text-sm mb-2">Option 4 *</label>
                    <input type="text" name="questions[${questionCount-1}][option4]" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                </div>
            </div>

            <div>
                <label class="block text-gray-700 text-sm font-bold mb-2">Réponse correcte *</label>
                <select name="questions[${questionCount-1}][correct]" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                    <option value="">Sélectionner la bonne réponse</option>
                    <option value="1">Option 1</option>
                    <option value="2">Option 2</option>
                    <option value="3">Option 3</option>
                    <option value="4">Option 4</option>
                </select>
            </div>
        </div>
    `;
    container.insertAdjacentHTML('beforeend', questionHTML);
}