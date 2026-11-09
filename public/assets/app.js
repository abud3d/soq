document.addEventListener('click',e=>{const b=e.target.closest('[data-view]');if(b){localStorage.setItem('nshir-view',b.dataset.view);document.getElementById('ads')?.classList.toggle('list',b.dataset.view==='list');}});
document.addEventListener('DOMContentLoaded',()=>{if(localStorage.getItem('nshir-view')==='list')document.getElementById('ads')?.classList.add('list');});
