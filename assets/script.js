const newProjectBox = document.querySelector('.new-project');
        const gearIcon = document.querySelector('.gear-icon');
        const box = document.querySelector('.delete-box')

        newProjectBox.addEventListener('mouseenter', function() {
            gearIcon.classList.add('show-gear')
        })
        
        newProjectBox.addEventListener('mouseleave', function() {
            gearIcon.classList.remove('show-gear')
        })
       gearIcon.addEventListener('click', function(){
            if(box.style.display === "none") {
                box.style.display = "block";
            } else {
                box.style.display = "none";
            }
})





