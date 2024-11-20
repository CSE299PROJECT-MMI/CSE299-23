$(document).ready(function () {
    $('#doctor_name, #appointment_date').on('change', function () {
        const department = $('#department_name').val();
        const doctor = $('#doctor_name').val();
        const date = $('#appointment_date').val();

        if (department && doctor && date) {
            $.ajax({
                url: 'get_slots.php',
                method: 'POST',
                data: { department_name: department, doctor_name: doctor, appointment_date: date },
                success: function (response) {
                    const res = JSON.parse(response);
                    if (res.status === 'success') {
                        const slots = res.slots;
                        const slotSelect = $('#appointment_time');
                        slotSelect.empty();
                        slotSelect.append('<option value="">Select Time Slot</option>');
                        slots.forEach(slot => {
                            slotSelect.append(`<option value="${slot}">${slot}</option>`);
                        });
                    } else {
                        alert(res.message || 'Failed to fetch slots');
                    }
                },
                error: function () {
                    alert('An error occurred while fetching slots.');
                }
            });
        }
    });
});
