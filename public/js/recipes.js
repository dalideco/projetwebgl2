
const button = document.querySelector(".buttons");
let sweets = false;
const firstinput = document.querySelector("#trigger1");
const input = document.querySelector('.slides_container.spicy input:last-of-type');
console.log(input);

// @ts-ignore
firstinput.onchange=() => {
    
    // @ts-ignore
    if (firstinput.checked===true){
        
        document.body.scrollTo({
            top: 0,
            left: 0,
            behavior: "smooth"
        });
    }
}

// @ts-ignore
input.onchange=() => {
    
    // @ts-ignore
    if (input.checked===true){
        
        document.body.scrollTo({
            top: 0,
            left: 0,
            behavior: "smooth"
        });
    }
}



console.log()

button.addEventListener("click", () => {

    console.log(document.body.scrollTop);
    sweets = !document.body.scrollTop;
    const scrolling = sweets ? window.innerHeight : 0;
    const myclass = sweets ? "sweets" : "spicy";
    document.body.scrollTo({
        top: scrolling,
        left: 0,
        behavior: "smooth"
    });

    const myCheck = document.querySelector(`.${myclass} > .slides > input:first-of-type `)
    console.log(myCheck);
    // @ts-ignore
    myCheck.checked = true;

})







// for (const button of buttons) {
//   button.addEventListener('click', () => {
//      var id = button.getAttribute("id");

//      var layerClass = ".top-layer";
//      var layers = document.querySelectorAll(layerClass);
//      for (const layer of layers) {
//        layer.classList.toggle("active");
//      }
//   });
// }