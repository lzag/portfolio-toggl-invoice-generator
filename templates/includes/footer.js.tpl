document.getElementById('searchForm').addEventListener('submit', (e) => {
  const term = document.getElementById('searchTerm').value;
  e.target.action += term;
});
