function matchUsers() {
    fetch('match_users.php')
    .then(response => response.text())
    .then(data => {
        document.getElementById('matchResult').innerHTML = data;
    })
    .catch(error => console.error('Error:', error));
}
