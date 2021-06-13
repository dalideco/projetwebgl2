// document.querySelector('#Vector_6').style.fill="red";
const mainColor= '#cccccc'

const liTable = document.querySelectorAll('.myMap ul li');

const colorDict=['rgba(233, 27, 27,1)','rgba(26, 104, 238, 1)','rgba(18, 88, 3, 1)']

const vectorSelectors= ['#Vector_6','#Vector_7','#Vector_36','#Vector_37','#Vector_26','#Vector_27']

const vectors = vectorSelectors.map(Sell=> document.querySelector(Sell));


vectors.forEach(vect=>{
    vect.style.transition= 'fill 300ms linear'
    vect.style.fill=mainColor
})

liTable.forEach((li,index)=>{
    li.addEventListener('mouseover',()=>{
        vectors.forEach(vector=>{
            vector.style.fill= colorDict[index] ;
        })
    })
    li.addEventListener('mouseout',()=>{
        vectors.forEach(vector=>{
            vector.style.fill= mainColor ;
        })
    })
})



