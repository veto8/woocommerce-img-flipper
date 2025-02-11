window.onload = async function()
{
    const e = document.querySelectorAll('[data-galleryimg]');
    let preloads = [];
    for(let i=0;i<e.length;i++)
    {
        if(e[i].tagName === 'IMG')
        {
            if (e[i].hasAttribute('data-galleryimg'))
            {
                const imgs = JSON.parse(e[i].dataset.galleryimg);

              if(imgs.length)
                {
                    let x =  { 'src': imgs[0].src, 'srcset':imgs[0].srcset};
                    //preloads.push(x);

/*
e[i].onmouseover = (function(){
 console.log("Mouse action started!")
})

e[i].onmouseleave = (function(){
 console.log("Mouse action terminated!") 
})
                    */
var start = 0;
var end   = 0;
                    
           e[i].ontouchstart  = (function(ev){
               ev.preventDefault();
               start = Date.now();

           e[i].classList.add("loop_img_gallery");
           e[i].src = imgs[0]['src']           
           if(e[i].hasAttribute('srcset')) {
               e[i].srcset = imgs[0]['srcset'];                                                
           }                        
  //  console.log("Touch action started!")
//    alert("xxxxx");
})

e[i].ontouchend  = (function(ev){
    console.log("Touch action terminated!")
    end = Date.now();
    let diff = end-start;
    if (diff < 500)
    {
         window.location.href = ev.target.parentNode.href ;        
//        alert(ev.target.href);
    }

    
          e[i].classList.remove("loop_img_gallery");
          e[i].src = imgs[imgs.length-1]['src'];
           if(e[i].hasAttribute('srcset')) {          
             e[i].srcset = imgs[imgs.length-1]['srcset'];
           }    
})





                    
e[i].addEventListener(
  "mouseenter",
   async (event) => {
       setTimeout( async () => {
           //console.log("...mouseover");
           //console.log(imgs[0]['src']);
           //console.log(e[i].src );
           //console.log(e[i] );                                     
           e[i].classList.add("loop_img_gallery");
           e[i].src = imgs[0]['src']           
           if(e[i].hasAttribute('srcset')) {
               e[i].srcset = imgs[0]['srcset'];                                                
           }

       //await flipp(e[i],imgs);
    }, 100);
  },
  false,
);


e[i].addEventListener(
  "mouseleave",
   async (event) => {
      setTimeout( async () => {
          //await flipp(e[i],imgs);
          //console.log("...remove class");
          e[i].classList.remove("loop_img_gallery");
          e[i].src = imgs[imgs.length-1]['src'];
           if(e[i].hasAttribute('srcset')) {          
             e[i].srcset = imgs[imgs.length-1]['srcset'];
           }

    }, 100);
  },
  false,
);

                    
}

            }
        }
    }

   //await  preload_flipping_images(preloads);
};



  function tapHandler(event) {
                    alert("xxxxx");
                }

async function preload_flipping_images(imgs)
{
    let div = document.createElement("div");
    div.setAttribute('id', 'img_holder');
    div.style.display = "none";
    document.body.appendChild(div);
    const timer = ms => new Promise(res => setTimeout(res, ms))
    async function load () {
    for(let i =0;i< imgs.length;i++) {
        let img = new Image();
        img.src = imgs[i]['src'];        
        if(imgs[i]['srcset'])
        {
          img.srcset = imgs[i]['srcset'];
        }
        img.onload = function()
        {
          div.appendChild(img);   
        }
        await timer(1000);
    }

    }
load();    
}

async function flipp(e,imgs){
    let loops = 0 ;
    const timer = ms => new Promise(res => setTimeout(res, ms))
    async function load () {
        let i = 0;
        //console.log(e.classList.contains("loop_img_gallery"));
        while(loops <3 && e.classList.contains("loop_img_gallery") ) {
            if(i === imgs.length-1 ) {
                i = 0;
                loops++;
            }    
            //console.log(i);
          e.src = imgs[i]['src'];
          e.srcset = imgs[i]['srcset'];
            

        i++;
        await timer(5000);
    }
}

load();
    
}


