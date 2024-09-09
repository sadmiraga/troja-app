var goBackButton = document.getElementById("back-button");
goBackButton.addEventListener('click', goBack);

function goBack() {
    var history = JSON.parse(sessionStorage.getItem('pageHistory')) || [];
    if (history.length > 1) {
        history.pop(); // Remove current URL
        var previousUrl = history.pop(); // Get the previous URL

        if (!previousUrl.includes('/app')) {
            window.history.back();
            sessionStorage.setItem('pageHistory', JSON.stringify(history));
        }
        
    } else {
        window.history.back();
    }
}