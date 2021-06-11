let myUlShown= false;
const profileButton= document.querySelector('.topBar .topButton');
const myUl = document.querySelector('.topBar ul');

// @ts-ignore
profileButton.onclick=()=>{
    myUlShown = !myUlShown;
    // @ts-ignore
    myUl.style.transform=myUlShown?'none':'scaleY(0)';
}