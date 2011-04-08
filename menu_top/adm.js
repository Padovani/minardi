 function confirmAction(message){
        if(confirm(message)){
            return true;
        }else{
            return false;
        }
    }

function somente_numero(campo,qtd,event){
var digits="0123456789"
var campo_temp

    if(campo.value.length > qtd && event.keyCode != 8 ) return false;

    for (var i=0;i<campo.value.length;i++){
        campo_temp=campo.value.substring(i,i+1)
        if (digits.indexOf(campo_temp)==-1){
            campo.value = campo.value.substring(0,i);
        }
    }
}  