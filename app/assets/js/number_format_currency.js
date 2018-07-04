function numberCurrency(b){
var _minus = false;
if (b<0) _minus = true;
b = b.toString();
b=b.replace(".","");
b=b.replace("-","");
c = "";
panjang = b.length;
j = 0;
for (i = panjang; i > 0; i--){
j = j + 1;
if (((j % 3) == 1) && (j != 1)){
c = b.substr(i-1,1) + "." + c;
} else {
c = b.substr(i-1,1) + c;
}
}
if (_minus) c = "-" + c ;
return c;
}

function numbersonly(ini, e){
  if (e.keyCode>=49){
    if(e.keyCode<=57){
  a = ini.value.toString().replace(".","");
  b = a.replace(/[^\d]/g,"");
  b = (b=="0")?String.fromCharCode(e.keyCode):b + String.fromCharCode(e.keyCode);
  ini.value = numberCurrency(b);
  return false;
  }
  else if(e.keyCode<=105){
  if(e.keyCode>=96){
  //e.keycode = e.keycode - 47;
  a = ini.value.toString().replace(".","");
  b = a.replace(/[^\d]/g,"");
  b = (b=="0")?String.fromCharCode(e.keyCode-48):b + String.fromCharCode(e.keyCode-48);
  ini.value = numberCurrency(b);
//alert(e.keycode);
  return false;
  }
  else {return false;}
  }
  else {
  return false; }
  }else if (e.keyCode==48){
  a = ini.value.replace(".","") + String.fromCharCode(e.keyCode);
  b = a.replace(/[^\d]/g,"");
  if (parseFloat(b)!=0){
  ini.value = numberCurrency(b);
  return false;
  } else {
  return false;
  }
  }else if (e.keyCode==95){
  a = ini.value.replace(".","") + String.fromCharCode(e.keyCode-48);
  b = a.replace(/[^\d]/g,"");
  if (parseFloat(b)!=0){
  ini.value = numberCurrency(b);
  return false;
      } else {
  return false;
    }
   }else if (e.keyCode==8 || e.keycode==46){
  a = ini.value.replace(".","");
    b = a.replace(/[^\d]/g,"");
  b = b.substr(0,b.length -1);
    if (numberCurrency(b)!=""){
      ini.value = numberCurrency(b);
    }     else {
    ini.value = "";
  }

  return false;
    } else if (e.keyCode==9){
  return true;
      } else if (e.keyCode==17){
  return true;
    }   else {
//alert (e.keyCode);
  return false;
  } 

    }