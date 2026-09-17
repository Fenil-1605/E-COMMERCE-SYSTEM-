document.addEventListener('DOMContentLoaded',()=>{
  document.querySelectorAll('.alert').forEach(el=>{
    setTimeout(()=>{ if(el.classList.contains('alert-success')) el.remove(); },5000);
  });
});
