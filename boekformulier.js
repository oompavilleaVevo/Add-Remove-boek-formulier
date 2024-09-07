class BookForm {
    // Constructor om het formulier, de verzendknop en de API-URL te initialiseren
    constructor(formId, submitButtonId, apiUrl) {
        this.form = document.getElementById(formId);
        this.submitButton = document.getElementById(submitButtonId);
        // Sla de URL op waarnaar de formulierdata wordt verstuurd
        this.apiUrl = apiUrl;
        // Koppel het 'submit'-event van het formulier aan de handleSubmit-functie
        this.form.addEventListener('submit', this.handleSubmit.bind(this));
    }

    async handleSubmit(event) {
        // Voorkomt de standaardactie van het formulier 
        event.preventDefault();
        // Maak een FormData-object met de gegevens van het formulier
        const formData = new FormData(this.form);

        // Probeer de formulierdata via een POST-verzoek naar de opgegeven API-URL te sturen
        try {
            const response = await fetch(this.apiUrl, {
                method: 'POST', 
                body: formData  
            });

            // Parseer het JSON-antwoord van de server
            const data = await response.json();

            // Verwerk het serverantwoord nadat de data ontvangen is
            this.handleResponse(data);

        } catch (error) {
            // Log de fout indien er iets misgaat met het verzoek
            console.error('Fout:', error);
            alert('Er is een fout opgetreden.');
        }
    }

    // Methode om het serverantwoord te verwerken en de interface bij te werken
    handleResponse(data) {
        // Log de boekgegevens en het boek-ID van het serverantwoord
        console.log('Boek gegevens:', data.book_data);
        console.log('Boek ID:', data.book_id);

        // Toon een bericht aan de gebruiker met het serverantwoord
        alert(data.message + ' Nu kunt u het boek aan een boekenkast toevoegen.');
    }
}

// Instantieer de BookForm-klasse
// Parameters: 'bookForm' is het formulier-ID, 'submit' is het knop-ID, en 'boekopslaan.php' is de API-URL om boeken op te slaan
const bookForm = new BookForm('bookForm', 'submit', 'boekopslaan.php');
