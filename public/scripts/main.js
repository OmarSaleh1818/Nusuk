
// == Toggle Side bar Script ==

const sidebarToggleBtn = document.getElementById('sidebar-toggler-btn');
const sidebar = document.getElementById('sidebar');

sidebarToggleBtn.addEventListener("click",function(){
    sidebar.classList.toggle('collapsed')
})
