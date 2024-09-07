class BookshelfManager {
    constructor() {
        this.resultDiv = document.getElementById('result');
        this.booksTableBody = document.getElementById('booksTable').querySelector('tbody');
        this.bookshelfTableBody = document.getElementById('bookshelfTable').querySelector('tbody');

        // Koppel de formulieren aan hun respectievelijke event handlers
        this.bindForm('addToShelfForm', this.addToShelf.bind(this), 'boekenkastvoeg.php');
        this.bindForm('deleteBookForm', this.deleteBook.bind(this), 'verwijderboek.php');
        this.bindForm('removeFromShelfForm', this.removeFromShelf.bind(this), 'verwijderboekenkast.php');

        // Laad de initiële data voor boeken en boekenkast
        this.loadBooks();
        this.loadBookshelf();
    }
    bindForm(formId, submitHandler, apiUrl) {
        const form = document.getElementById(formId);
        form.addEventListener('submit', (event) => {
            event.preventDefault(); // Voorkom de standaard actie van het formulier
            const formData = new FormData(form); // Verzamel de gegevens van het formulier
            submitHandler(apiUrl, formData); // Roep de submit-handler aan met de API en formulierdata
        });
    }
    // Voeg een boek toe aan de boekenkast
    async addToShelf(apiUrl, formData) {
        try {
            const data = await this.postFormData(apiUrl, formData);
            this.displayResult('success', data.message); // Toon succesbericht
            this.loadBooks(); 
            this.loadBookshelf(); 
        } catch (error) {
            this.displayResult('danger', 'Er is een fout opgetreden bij het toevoegen van het boek aan de boekenkast.'); // Foutmelding
        }
    }
    // Verwijder een boek
    async deleteBook(apiUrl, formData) {
        try {
            const data = await this.postFormData(apiUrl, formData);
            if (data.error) {
                this.displayResult('danger', data.error); // Toont foutbericht
            } else {
                this.displayResult('success', data.message); // Toont succesbericht
                this.loadBooks(); 
                this.loadBookshelf(); 
            }
        } catch (error) {
            this.displayResult('danger', 'Er is een fout opgetreden bij het verwijderen van het boek.');
        }
    }
    // Verwijder een boek uit de boekenkast
    async removeFromShelf(apiUrl, formData) {
        try {
            const data = await this.postFormData(apiUrl, formData);
            if (data.error) {
                this.displayResult('danger', data.error); // Toon foutbericht
            } else {
                this.displayResult('success', data.message); // Toon succesbericht
                this.loadBooks(); // Herlaad de lijst met boeken
                this.loadBookshelf(); // Herlaad de boekenkast
            }
        } catch (error) {
            this.displayResult('danger', 'Er is een fout opgetreden bij het verwijderen van het boek uit de boekenkast.'); // Foutmelding
        }
    }
    // Post formulierdata naar een API en ontvang een JSON-antwoord
    async postFormData(apiUrl, formData) {
        const response = await fetch(apiUrl, { method: 'POST', body: formData });
        if (!response.ok) throw new Error('Netwerkantwoord was niet ok');
        return await response.json(); // Retourneer het geparseerde JSON-antwoord
    }
    // Toon het resultaat (bericht) aan de gebruiker
    displayResult(alertType, message) {
        this.resultDiv.className = `alert alert-${alertType}`; 
        this.resultDiv.textContent = message; // Toon het bericht
        this.resultDiv.style.display = 'block'; // Maak het zichtbaar
    }
    // Laad de lijst met boeken uit de database
    async loadBooks() {
        try {
            const data = await this.fetchData('boekophaal.php');
            this.renderTable(this.booksTableBody, data, 'books'); // Render de gegevens in de tabel
        } catch (error) {
            console.error('Fout bij het laden van boeken:', error); 
        }
    }
    // Laad de lijst met boeken in de boekenkast uit de database
    async loadBookshelf() {
        try {
            const data = await this.fetchData('boekenkastophaal.php');
            this.renderTable(this.bookshelfTableBody, data, 'bookshelf'); // Render de gegevens in de tabel
        } catch (error) {
            console.error('Fout bij het laden van de boekenkast:', error); // Log eventuele fouten
        }
    }
    // Haal data op van een opgegeven API
    async fetchData(apiUrl) {
        const response = await fetch(apiUrl);
        if (!response.ok) throw new Error('Netwerkantwoord was niet ok');
        return await response.json();
    }
    // Render een tabel met de gegevens
    renderTable(tableBody, data, type) {
        tableBody.innerHTML = ''; 
        data.forEach(book => {
            const row = tableBody.insertRow(); // Voeg een nieuwe rij toe aan de tabel
            row.insertCell(0).textContent = book.book_ID || 'N/A'; 
            row.insertCell(1).textContent = book.title || 'Onbekend'; 
        });
    }
}
// Instantieer de BookshelfManager-klasse zodra de DOM volledig is geladen
document.addEventListener('DOMContentLoaded', () => {
    new BookshelfManager(); // Creëer een nieuw BookshelfManager-object
});
