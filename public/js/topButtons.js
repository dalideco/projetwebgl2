let myUlShown= false;
const profileButton= document.querySelector('.topBar .topButton');
const myUl = document.querySelector('.topBar ul');

profileButton.onclick=()=>{
    myUlShown = !myUlShown;
    myUl.style.transform=myUlShown?'none':'scaleY(0)';
}