window.setInterval('uptime()', 1000)
var i2=window.setInterval('animation()', (Math.random()*60000)+10000);
var i1,sw=1;
function uptime()
{
    var clock=document.getElementById('clock');
    var d=new Date();
    clock.innerHTML=('<div>'+d.getHours()+'</div><div>'+d.getMinutes()+'</div><div>'+d.getSeconds()+'</div>');
}
function animation()
{
    if(sw==1)
    {
        i1=window.setInterval('downAnimation()', 50);
        sw=0;
    }else
    {
        i1=window.setInterval('upAnimation()', 50);
        sw=1;
    }
}
function upAnimation()
{
    window.clearInterval(i2);
    var a=document.getElementById('xmp1');
    var b=document.getElementById('xmp2');
    a.style.top=(a.offsetTop-1)+'px';
    if(a.offsetTop<=18)
    {
        window.clearInterval(i1);
        b.style.display='block';
        i2=window.setInterval('animation()', (Math.random()*60000)+10000);
    }
}
function downAnimation()
{
    window.clearInterval(i2);
    var a=document.getElementById('xmp1');
    var b=document.getElementById('xmp2');
    a.style.top=(a.offsetTop+2)+'px';
    if(a.offsetTop>=50)
    {
        window.clearInterval(i1);
        i2=window.setInterval('animation()', (Math.random()*60000)+10000);
        b.style.display='none';
    }
}

