window.onload=function() {
    canv=document.getElementById("gc");
    ctx=canv.getContext("2d");
    document.addEventListener("keydown",keyPush);
    setInterval(game,1500/15);
    scoreboard = document.getElementById("scoreboard");
    score = 0;
    lastscore = document.getElementById("lastscore");
    scorememory = 0;
    bestscore = document.getElementById("bestscore");

}
px=py=10;
gs=tc=20;
ax=ay=5;
xv=yv=0;
trail=[];
tail = 5;





function game() {
    px+=xv;
    py+=yv;
    if(px<0) {
        px= tc-1;
    }
    if(px>tc-1) {
        px= 0;
    }
    if(py<0) {
        py= tc-1;
    }
    if(py>tc-1) {
        py= 0;
    }
    ctx.fillStyle="black";
    ctx.fillRect(0,0,canv.width,canv.height);

    ctx.fillStyle="lime";
    for(var i=0;i<trail.length;i++) {
        ctx.fillRect(trail[i].x*gs,trail[i].y*gs,gs-1,gs-1);
        if(trail[i].x==px && trail[i].y==py) {
            tail = 5;
            score = 0;
            bestscore.innerHTML != score;
            bestscore.innerHTML != lastscore;
            scorememory !== score;
            lastscore.innerHTML = scorememory;
        }
    }

    if(bestscore.innerHTML >= lastscore.innerHTML) {
        bestscore.innerHTML != score;
    }

    if(score > lastscore.innerHTML) {
        bestscore.innerHTML = score;
    }

    if(score < lastscore.innerHTML) {
        bestscore.innerHTML != score;
        bestscore.innerHTML != lastscore.innerHTML;
    }

    trail.push({x:px,y:py});
    while(trail.length>tail) {
        trail.shift();
    }

    if(ax==px && ay==py) {
        tail++;
        ax=Math.floor(Math.random()*tc);
        ay=Math.floor(Math.random()*tc);
        score += 1;
        scoreboard.innerHTML = score;
        scorememory = score;
    }

    ctx.fillStyle="yellow";
    ctx.fillRect(ax*gs,ay*gs,gs-1,gs-1);
}

function keyPush(evt) {
    switch(evt.keyCode) {
        case 37:
            xv=-1;yv=0;
            break;
        case 38:
            xv=0;yv=-1;
            break;
        case 39:
            xv=1;yv=0;
            break;
        case 40:
            xv=0;yv=1;
            break;
    }
}

