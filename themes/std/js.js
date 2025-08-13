function openmenu(name){
    var menu = document.getElementsByClassName(name)[0];

    if(!menu.style.display){
        menu.style.display = 'block';
    } else if(menu.style.display === 'none'){
        menu.style.display = 'block';
    } else if(menu.style.display !== 'none'){
        menu.style.display = 'none';
    }
}

function music(filename){
    var player = document.getElementsByClassName('player')[0];
    player.src = filename;
    player.style.display = 'block';
}