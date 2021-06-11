
const button = document.querySelector(".buttons");
let sweets = false;

console.log(button);
const firstinput = document.querySelector("#trigger1");
console.log(firstinput);
// @ts-ignore
firstinput.onchange=() => {
    console.log(firstinput);
    // @ts-ignore
    if (firstinput.checked===true){
        console.log("checked");
        document.body.scrollTo({
            top: 0,
            left: 0,
            behavior: "smooth"
        });
    }

}

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

    const myCheck = document.querySelector(`.${myclass} > .slides > input:last-of-type `)
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