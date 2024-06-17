document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('bookForm').addEventListener('submit', function(event) {
        event.preventDefault();
        
        let title = document.getElementById('title').value;
        let author = document.getElementById('author').value;
        let action = event.submitter.value;

        if (action === 'may') {
            title = title.toUpperCase();
            author = author.toUpperCase();
        } else if (action === 'min') {
            title = title.toLowerCase();
            author = author.toLowerCase();
        }

        document.getElementById('bookTitle').textContent = title;
        document.getElementById('bookAuthor').textContent = author;
    });

    document.getElementById('changeColorButton').addEventListener('click', function() {
        let selectedColor = document.getElementById('colorPicker').value;
        document.getElementById('overlay').style.backgroundColor = selectedColor;
    });
});
