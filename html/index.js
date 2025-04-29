window.addEventListener('scroll', function(){
    const header = document.querySelector('.sideViewLeft');
    const scrollTriggerPx = window.innerHeight;

    if(window.scrollY > scrollTriggerPx){
        header.classList.add('movedUp');
    } else {
        header.classList.remove('movedUp');
    }
});