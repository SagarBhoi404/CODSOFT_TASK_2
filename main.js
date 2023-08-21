
// Tab Change

function tab_change(tabtochange) {
    if (tabtochange == 'one_way') {
        document.getElementById('round_trip').hidden = false
        document.getElementById(tabtochange).hidden = true
        document.getElementById('round_trip_btn').classList.add('active')
        document.getElementById('one_way_btn').classList.remove('active')
    }

    if (tabtochange == 'round_trip') {
        document.getElementById('one_way').hidden = false
        document.getElementById(tabtochange).hidden = true
        document.getElementById('round_trip_btn').classList.remove('active')
        document.getElementById('one_way_btn').classList.add('active')
    }
}

// Passanger Counter

function passenger_value_increase_RT() {
    let passenger_value = document.getElementById('passenger').value
    passenger_value = parseInt(passenger_value) + 1
    document.getElementById('passenger').value = passenger_value
}

function passenger_value_decrease_RT() {
    let passenger_value = document.getElementById('passenger').value
    if (passenger_value > 1) {
        passenger_value = parseInt(passenger_value) - 1
    }
    document.getElementById('passenger').value = passenger_value
}

function passenger_value_increase_OW() {
    let passenger_value = document.getElementById('passenger1').value
    passenger_value = parseInt(passenger_value) + 1
    document.getElementById('passenger1').value = passenger_value
}

function passenger_value_decrease_OW() {
    let passenger_value = document.getElementById('passenger1').value
    if (passenger_value > 1) {
        passenger_value = parseInt(passenger_value) - 1
    }
    document.getElementById('passenger1').value = passenger_value
}

function print_ticket(ticketID) {
    window.jsPDF = window.jspdf.jsPDF;

    var doc = new jsPDF();

    // Source HTMLElement or a string containing HTML.
    var elementHTML = document.querySelector(`#ticket${ticketID}`);

    doc.html(elementHTML, {
        callback: function (doc) {
            // Save the PDF
            doc.save(`Ticket_${ticketID}_Online_Booking_System.pdf`);
        },
        x: 15,
        y: 15,
        width: 170, //target width in the PDF document
        windowWidth: 650 //window width in CSS pixels
    });
}
