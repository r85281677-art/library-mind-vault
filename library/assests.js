async function api(path, opts={}){
  const res = await fetch(path, {headers:{'Content-Type':'application/json'}, ...opts});
  return res.json();
}
async function addToLibrary(bookId){
  const data = await api('api/library.php', {method:'POST', body:JSON.stringify({book_id:bookId})});
  alert(data.message || data.error);
}
function searchBooks(q){
  document.querySelectorAll('.book').forEach(b=>{
    const t = b.dataset.title.toLowerCase();
    b.style.display = t.includes(q.toLowerCase()) ? '' : 'none';
  });
}