function editSuccess_on(){
    document.getElementById("status-overlay").style.display='block';
    document.getElementById("header-admin").style.zIndex="-1";
}
function edit_off(){
    document.getElementById("status-overlay").style.display='none';
    document.getElementById("header-admin").style.zIndex="60";
    url();
}
function url(){
    window.history.go(-1);
}
function changePass_on(){
    
}