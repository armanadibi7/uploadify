
async function selected_building(preload, battery) {




    document.getElementById('step3').style.visibility = 'visible';
   
    function removeOptions(selectElement) {
        var i, L = selectElement.options.length - 1;
        for (i = L; i >= 0; i--) {
            selectElement.remove(i);
        }
    }


    removeOptions(document.getElementById('selectedBattery'));

    var select = document.getElementById('selectedBuilding');
    value = select.options[select.selectedIndex].value;
    console.log(value);
    console.dir(select);
    if (typeof  preload != 'undefined') {
        value = preload;
    }
    document.getElementById('step3').style.visibility = 'visible';
   await $.ajax({
        type: 'GET',
        url: '/Intervention/getBattery/'+ value,
        success: function (data) {


            console.log(data);
            var x = document.createElement("OPTION");
            x.setAttribute("value", "Select");
            var t = document.createTextNode("--- Please Select ---");
            x.appendChild(t);
            document.getElementById("selectedBattery").appendChild(x);

            $.each(data, function (i, j) {


                var x = document.createElement("OPTION");
                x.setAttribute("value", j.id);
                if (j.id == battery) {

                    x.setAttribute('selected', 'selected');
                }
                var t = document.createTextNode("Battery ID : " + j.id + " - " + j.status);
                x.appendChild(t);
                document.getElementById("selectedBattery").appendChild(x);
            });
        }
    });
    return null;
}

async function selected_battery(preload,column) {

    document.getElementById('step3').style.visibility = 'visible';
    document.getElementById('step4').style.visibility = 'visible';
    document.getElementById('step5').style.visibility = 'visible';
    document.getElementById('step7').style.visibility = 'visible';
    document.getElementById('step8').style.visibility = 'visible';

    function removeOptions(selectElement) {
        var i, L = selectElement.options.length - 1;
        for (i = L; i >= 0; i--) {
            selectElement.remove(i);
        }
    }


    removeOptions(document.getElementById('selectedColumn'));
    var select = document.getElementById('selectedBattery');

    console.dir(select);
    value = select.options[select.selectedIndex].value;
    console.log(value);
    if (typeof preload != 'undefined') {
        value = preload;
    }
    document.getElementById('step4').style.visibility = 'visible';
    
    await   $.ajax({
        type: 'GET',
        url: '/Intervention/getColumn/' + value,
        success: function (data) {

            console.log(data);
            var x = document.createElement("OPTION");
            x.setAttribute("value", "Select");
            var t = document.createTextNode("--- Please Select ---");
            x.appendChild(t);
            document.getElementById("selectedColumn").appendChild(x);
            var x = document.createElement("OPTION");
            x.setAttribute("value", "null");
            var t = document.createTextNode("NONE");
            x.appendChild(t);
            document.getElementById("selectedColumn").appendChild(x);
            $.each(data, function (i, j) {

                var x = document.createElement("OPTION");
                x.setAttribute("value", j.id);
                if (j.id == column) {

                    x.setAttribute('selected', 'selected');
                }
                var t = document.createTextNode("Column ID : " + j.id + " - " + j.status);
                x.appendChild(t);
                document.getElementById("selectedColumn").appendChild(x);
            });
            
        }
    });
    if (typeof preload != 'undefined') {

        document.getElementById('step3').style.visibility = 'visible';
        document.getElementById('step4').style.visibility = 'visible';
        document.getElementById('step5').style.visibility = 'visible';
        document.getElementById('step7').style.visibility = 'visible';
        document.getElementById('step8').style.visibility = 'visible';

        await selected_column(0, 0);

        await selected_elevator(0);

    }
    
}
async function selected_column(preload,elevator) {

    document.getElementById('step5').style.visibility = 'visible';

    function removeOptions(selectElement) {
        var i, L = selectElement.options.length - 1;
        for (i = L; i >= 0; i--) {
            selectElement.remove(i);
        }
    }


    removeOptions(document.getElementById('selectedElevator'));

    var select = document.getElementById('selectedColumn');
    value = select.options[select.selectedIndex].value;
    console.log(value);
    if (typeof preload != 'undefined') {
        value = preload;
    }
    if (value == "null" || value == "select") {
        value = "0";
    }
    await  $.ajax({
        type: 'GET',
        url: '/Intervention/getElevator/' + value,
        success: function (data) {


            console.log(data);
            var x = document.createElement("OPTION");
            x.setAttribute("value", "Select");
            var t = document.createTextNode("--- Please Select ---");
            x.appendChild(t);
            document.getElementById("selectedElevator").appendChild(x);
            var x = document.createElement("OPTION");
            x.setAttribute("value", "null");
            var t = document.createTextNode("NONE");
            x.appendChild(t);
            document.getElementById("selectedElevator").appendChild(x);

            $.each(data, function (i, j) {

                console.log(j.id)
                var x = document.createElement("OPTION");
                x.setAttribute("value", j.id);
                if (j.id == elevator) {

                    x.setAttribute('selected', 'selected');
                }
                var t = document.createTextNode("Elevator ID : " + j.id + " - " + j.status);
                x.appendChild(t);
                document.getElementById("selectedElevator").appendChild(x);
            });
        }
    });


}
async function selected_elevator(preload) {
    document.getElementById('step7').style.visibility = 'visible';
    document.getElementById('step8').style.visibility = 'visible';


}

async function init() {
    const delay = ms => new Promise(res => setTimeout(res, ms));
    var url_string = window.location.href; //window.location.href
    var url = new URL(window.location.href);
    if (url_string.match("battery")) {
        document.getElementById('step3').style.visibility = 'visible';
        document.getElementById('step4').style.visibility = 'visible';
        document.getElementById('step5').style.visibility = 'visible';
        console.log(buildingValue); console.log(batteryValue);

        await selected_building(buildingValue, batteryValue);
        await selected_battery(batteryValue);


    }else if (url_string.match("column")) {
            document.getElementById('step3').style.visibility = 'visible';
            document.getElementById('step4').style.visibility = 'visible';
            document.getElementById('step5').style.visibility = 'visible';
            await selected_building(buildingValue, batteryValue);

            await selected_battery(batteryValue, columnValue);

            await selected_column(columnValue);
       
    }else  if (url_string.match("elevator/")) {


            document.getElementById('step3').style.visibility = 'visible';
            document.getElementById('step4').style.visibility = 'visible';
            document.getElementById('step5').style.visibility = 'visible';
            document.getElementById('step7').style.visibility = 'visible';
            document.getElementById('step8').style.visibility = 'visible';
            await selected_building(buildingValue, batteryValue);

            await selected_battery(batteryValue, columnValue);

            await selected_column(columnValue, elevatorValue);

            await selected_elevator(elevatorValue);
           
        }
    
}
    
$(document).ready(function () {
    init();
});