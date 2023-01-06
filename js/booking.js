const maquina = document.getElementById('maquines');
const dia = document.getElementById('datepicker');
const form = document.getElementById('form');
const div = document.getElementById('disp');
const temps_disp = document.getElementById('temps_disp');
var checkbox_on_list = [];
var all_checkbox = [];

function checkbox(){
    if (this.checked == true){
        checkbox_on_list.push(this);
    }
    else{
        for (let i = 0; i < checkbox_on_list.length; i++){
            if (checkbox_on_list[i] == this){
                checkbox_on_list.splice(i, 1);
            }
        }
    }
}

function removeCheckboxList(){
    checkbox_on_list = [];
    for (let i = 0; i < all_checkbox.length; i++){
        all_checkbox[i].removeEventListener('change', checkbox);
    }
    all_checkbox = []
}

function checkDate(date, today){
    if (moment(date, "DD/MM/YYYY", true).isValid()){
        date = date+" "+today.getHours().toString()+":"+today.getMinutes().toString()+":"+today.getSeconds().toString()+"."+today.getMilliseconds().toString();
        var dateMomentObject = moment(date, "DD/MM/YYYY hh:mm:ss.SSS");
        var dateObject = dateMomentObject.toDate();
        if (dateObject.getTime() >= (1+today.getTime())){
            return true;
        }
    }
    return false;
}

function reserva(){
    var today = new Date();
    if (maquina.value != '' && checkDate(dia.value, today)){
        removeCheckboxList();
        var table = document.createElement('table');
        table.setAttribute('class', 'table table-borderless table-disponibilitat');
        for (let i = 0; i < 2; i++){
            var tr = document.createElement('tr');
            var td1 = document.createElement('td');
            var td2 = document.createElement('td');
            var td3 = document.createElement('td');
            var td4 = document.createElement('td');
            var td5 = document.createElement('td');
            var td6 = document.createElement('td');
            
            
            td1.setAttribute('class', 'text-center border border-2 text-light bg-success');
            td2.setAttribute('class', 'text-center border border-2 text-light bg-success');
            td3.setAttribute('class', 'text-center border border-2 text-light bg-success');
            td4.setAttribute('class', 'text-center border border-2 text-light bg-success');
            td5.setAttribute('class', 'text-center border border-2 text-light bg-success');
            td6.setAttribute('class', 'text-center border border-2 text-light bg-success');
            if (i == 0){
                var text1 = document.createTextNode('09:00 - 09:59');
                var text2 = document.createTextNode('10:00 - 10:59');
                var text3 = document.createTextNode('11:00 - 11:59');
                var text4 = document.createTextNode('12:00 - 12:59');
                var text5 = document.createTextNode('13:00 - 13:59');
                var text6 = document.createTextNode('14:00 - 14:59');
                td1.setAttribute('id', '09:00 - 09:59');
                td2.setAttribute('id', '10:00 - 10:59');
                td3.setAttribute('id', '11:00 - 11:59');
                td4.setAttribute('id', '12:00 - 12:59');
                td5.setAttribute('id', '13:00 - 13:59');
                td6.setAttribute('id', '14:00 - 14:59');
            }
            else{
                var text1 = document.createTextNode('15:00 - 15:59');
                var text2 = document.createTextNode('16:00 - 16:59');
                var text3 = document.createTextNode('17:00 - 17:59');
                var text4 = document.createTextNode('18:00 - 18:59');
                var text5 = document.createTextNode('19:00 - 19:59');
                var text6 = document.createTextNode('20:00 - 20:59');
                td1.setAttribute('id', '15:00 - 15:59');
                td2.setAttribute('id', '16:00 - 16:59');
                td3.setAttribute('id', '17:00 - 17:59');
                td4.setAttribute('id', '18:00 - 18:59');
                td5.setAttribute('id', '19:00 - 19:59');
                td6.setAttribute('id', '20:00 - 20:59');
            }
            td1.appendChild(text1);
            td2.appendChild(text2);  
            td3.appendChild(text3);  
            td4.appendChild(text4);  
            td5.appendChild(text5);  
            td6.appendChild(text6);
            tr.appendChild(td1);
            tr.appendChild(td2);  
            tr.appendChild(td3);  
            tr.appendChild(td4);  
            tr.appendChild(td5);  
            tr.appendChild(td6);      
            table.appendChild(tr);
        }
        var data = {maquina: maquina.value, dia: dia.value};
        var request;
        var get_data;            
        var url = '/get-reserves';
        request = new XMLHttpRequest();
        request.onreadystatechange = function(){
            if (request.readyState == 4 && request.status == 200){
                get_data = JSON.parse(request.responseText);
                temps_disp.innerHTML = (180 - 60*((get_data['data2']).length)).toString() + " minuts.";
                ll = get_data['data'];
                for (let i = 0, cell; cell = table.getElementsByTagName('td')[i]; i++) {
                    h_out = cell.innerText.split(" - ")[1];
                    var d = dia.value+" "+h_out+":59";
                    var d_MomentObject = moment(d, "DD/MM/YYYY hh:mm:ss");
                    var d_dateObject = d_MomentObject.toDate();
                    if ((today.getTime()+1) >= d_dateObject.getTime()){
                        cell.classList.remove('bg-success');
                        cell.classList.add('bg-secondary');
                    }
                    else{
                        if (ll.includes(cell.id)){
                            cell.classList.remove('bg-success');
                            cell.classList.add('bg-danger');
                        }
                        else{
                            var checkbox_input = document.createElement('input');
                            checkbox_input.setAttribute('type', 'checkbox');
                            checkbox_input.setAttribute('name', 'hores');
                            checkbox_input.setAttribute('value', cell.id);
                            checkbox_input.setAttribute('class', 'checkbox-input')
                            checkbox_input.addEventListener('change', checkbox);
                            all_checkbox.push(checkbox_input);
                            cell.appendChild(checkbox_input);
                        }
                    }
                }
                div.innerHTML = "";
                div.appendChild(table);
            }
        }
        request.open('POST', url, true);
        request.send(JSON.stringify(data));
    }
    else{
        temps_disp.innerHTML = "-";
        div.innerHTML = "<p class='text-center'>No hi ha cap reserva disponible.</p>";
    }
}

maquina.addEventListener('change', reserva);

form.addEventListener('submit', function(ev){
    ev.preventDefault();
    var formSub = this;
    var today = new Date();
    if (maquina.value != '' && checkDate(dia.value, today)){
        if (checkbox_on_list.length > 0){
            var data = {dia: dia.value};
            var request;
            var get_data;            
            var url = '/get-reserves-usuari';
            request = new XMLHttpRequest();
            request.onreadystatechange = function(){
                if (request.readyState == 4 && request.status == 200){
                    get_data = JSON.parse(request.responseText);
                    ll = get_data['data'];
                    console.log(ll);
                    if (checkbox_on_list.length <= (3 - ll.length)){
                        formSub.submit();
                    }
                    else{
                        var missatge = "No pots reservar més de " + (180 - 60*(ll.length)).toString() + " minuts!";
                        alert(missatge);
                    }
                }
            }
            request.open('POST', url, true);
            request.send(JSON.stringify(data));
        }
        else{
            alert("No has seleccionat cap hora!");
        }
    }
    else{
        alert("Les dades introduides no són correctes!");
    }
});
 
