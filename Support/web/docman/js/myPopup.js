function myPopup(){
    this.title='';
    this.content='';
    this.setContent=function(content){
        this.content=content;
    }
    this.setTitle=function(title){
        this.title=title;
    }
    this.getTitle=function(){
        return this.title;
    }
    this.getContent=function(){
        return this.content;
    }
    this.show=function(){
        $("#cont").html(this.content);
        $(".title").html(this.title);
        $("#marco").fadeIn(200, "linear");
        var x=document.getElementById('closebutton');
        var y=document.getElementById('win');
        y.style.left=(parseInt(window.innerWidth/2)-parseInt(y.clientWidth/2))+'px';
        x.addEventListener('click',this.hide);
    }
    this.hide=function(){
        $("#marco").fadeOut(200, "linear");
        openfolder(document.getElementById('currentpath').value);
    }
}
function move(e)
{
    if(e.button==0)
    {
        var x=document.getElementById('win');
        var y=document.getElementById('titlebar');
        if(e.clientY>=0 && e.clientY<=500)
        {
            x.style.left=e.clientX-(x.clientWidth/2)+'px';
            x.style.top=e.clientY-10+'px';
        }
    }
}
function up(){
    removeEventListener('mousemove', move);
    removeEventListener('mouseup', up);
}
function ggg(e)
{
    addEventListener('mousemove',move);
    addEventListener('mouseup',up);
}
