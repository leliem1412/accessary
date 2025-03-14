@extends('app')

@section('css')
    <style>
        .calendar-container {
            padding: 20px;
            background-color: #fff;
            border: 1px solid #ccc;
            border-radius: 10px;
        }
    </style>
@endsection

@section('content')
    <div class="breakcrumb-container">
        <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item active" aria-current="page">Đặt hẹn</li>
            </ol>
        </nav>
        <div class="btn-breakcrumb-box">
            <button class="btn btn-primary pull-right btn_create">Thêm mới</button>
        </div>
   </div>

    <div class="row">
        <div class="col-md-12 col-md-offset-1">
           <div class="calendar-container">
                <div id='calendar'></div>
                <input type="hidden" name="appointments" value="{{ json_encode($appointments) }}">
           </div>
        </div>
    </div>

     <!-- Modal -->
     <div class="modal fade" id="createAppointmentModal" tabindex="-1" aria-labelledby="createAppointmentModal" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Đặt lịch</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                   <form name="createAppointmentForm" action="{{ route('appointment.store') }}" method="post">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="title" class="form-label">Tiêu đề</label>
                                <input class="form-control" type="text" name="title" id="title" placeholder="Nhập tiêu đề">
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="customer_id" class="form-label">Khách hàng</label>
                                <select class="form-select" aria-label="Default select example" name="customer_id" id="customer_id">
                                    <option selected>Chọn khách hàng</option>
                                   
                                    @foreach ($customers as $customer)
                                        <option value="{{ $customer['id'] }}">{{ $customer['name'] }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="service_id" class="form-label">Dịch vụ</label>
                                <select class="form-select" aria-label="Default select example" name="service_id" id="service_id">
                                    <option selected>Chọn dịch vụ</option>
                                   
                                    @foreach ($services as $service)
                                        <option value="{{ $service['id'] }}">{{ $service['name'] }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="start_date" class="form-label">Ngày bắt đầu</label>
                                <input type="datetime-local" name="start_date" class="form-control" id="start_date">
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="status" class="form-label">Tình trạng</label>
                                <select class="form-select" aria-label="Default select example" name="status" id="status">
                                    <option selected>Chọn tình trạng</option>
                                   
                                    @foreach ($status as $key => $value)
                                        <option value="{{ $key }}">{{ $value }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="created_by_id" class="form-label">Nhân viên phụ trách</label>
                                <select class="form-select" aria-label="Default select example" name="created_by_id" id="created_by_id">
                                    <option selected>Chọn nhân viên phụ trách</option>
                                   
                                    @foreach ($employees as $employee)
                                        <option value="{{ $employee['id'] }}">{{ $employee['name'] }}</option>
                                    @endforeach
                                </select>
                            </div>
                            
                            <div class="col-md-12 mb-3">
                                <label for="note" class="form-label">Ghi chú</label>
                                <textarea name="note" id="note" class="form-control"></textarea>
                            </div>
                        </div>
                   </form>
              
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Huỷ</button>
                    <button type="button" class="btn btn-primary save_apt">Lưu</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
<script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.js'></script>
<script>
    const Customer_ListView_Js = new class {
        appointment = [];
        calendar = null;

        constructor() {
            this.initField();
            this.handleCreateBtnClickEvent();
            this.handleSubmitCreateFormModalEvent();
            this.initFullCalendar();
        }

        initField() {
            this.$createBtnField = $('.btn_create');
            this.$createBtnModalCreate = $('.save_apt');
            this.$createAppointmentModal = $('#createAppointmentModal');
            this.$createAppointmentForm = $('form[name=createAppointmentForm]');
            this.$appointmentsInput = $('input[name=appointments]');
        }

        getAppointment() {
            const appointment = this.appointment;
            if (appointment.length > 0) return appointment;

            const appointmentJson = this.$appointmentsInput.val();
            if (!appointmentJson) return [];

            const appointmentData = JSON.parse(appointmentJson);
            appointmentData.forEach((item) => {
                const backgroundColor = this.getBackgroudCalendarItemColor(item['status']);
                appointment.push({
                    id: item['id'],
                    title: 'Dat hen',
                    start: item['start_date'],
                    end: item['end_date'],
                    extendedProps: {
                        note: item['note'],
                        customer_id: item['customer_id'],
                        created_by_id: item['created_by_id'],
                        service_id: item['service_id'],
                    },
                    ...backgroundColor,
                });
            });
            this.appointment.concat(appointment);
            return this.appointment;
        }

        setAppointment(appointmentData) {
            const backgroundColor = this.getBackgroudCalendarItemColor(appointmentData['status']);
            this.appointment.push({
                id: appointmentData['id'],
                title: 'Dat hen',
                start: appointmentData['start_date'],
                end: appointmentData['end_date'],
                extendedProps: {
                    note: appointmentData['note'],
                    customer_id: appointmentData['customer_id'],
                    created_by_id: appointmentData['created_by_id'],
                    service_id: appointmentData['service_id'],
                },
                ...backgroundColor,
            });
        }

        getBackgroudCalendarItemColor(status) {
            let backgroundColor = '';
            let borderColor = '';
            let textColor = '';

            switch (status) {
                case 'confirmed':
                    backgroundColor = '#a8e063';
                    borderColor = '#56ab2f';
                    textColor = '#fff';
                    break;

                case 'inproccess':
                    backgroundColor = '#3498db';
                    borderColor = '#2980b9';
                    textColor = '#fff';
                    break;

                case 'completed':
                    backgroundColor = '#FF5733';
                    borderColor = '#C70039';
                    textColor = '#fff';
                    break;
            }

            return { backgroundColor, borderColor, textColor };
        }

        initFullCalendar() {
            document.addEventListener('DOMContentLoaded', () => {
                var calendarEl = document.getElementById('calendar');
                const appointment = this.getAppointment();
                var calendar = new FullCalendar.Calendar(calendarEl, {
                    locale: 'vi',
                    initialDate: '2025-02-07',
                    selectable: true, // Cho phép chọn ngày
                    editable: true, // Cho phép kéo thả chỉnh sửa
                    slotMinTime: '08:00:00', // Bắt đầu từ 8:00 sáng
                    slotMaxTime: '18:00:00', // Kết thúc lúc 6:00 chiều
                    events: appointment,
                    initialDate: new Date(), 
                    initialView: 'timeGridDay',
                    headerToolbar: {
                        left: 'prev,next today',
                        center: 'title',
                        right: 'timeGridDay,timeGridWeek,dayGridMonth'
                    },
                    dateClick: (info) => {
                        console.log(info['dateStr']);
                        const formattedDate = info['dateStr'].slice(0, 16); 
                        this.$createAppointmentForm.find('input[name=start_date]').val(formattedDate);
                        this.$createAppointmentModal.modal('show');
                    },
                    eventClick: (info) => {
                        console.log(info.event);
                        // let newTitle = prompt("Chỉnh sửa tiêu đề sự kiện:", info.event.title);
                        // if (newTitle) {
                        //     info.event.setProp('title', newTitle);
                        // } 
                        // else if (confirm("Bạn có muốn xóa sự kiện này không?")) {
                        //     info.event.remove();
                        // }
                    }
                });
                calendar.render();
                this.calendar = calendar;
            });
        }

       handleCreateBtnClickEvent() {
            this.$createBtnField.on('click', (event) => {
                event.preventDefault();
                this.$createAppointmentModal.modal('show');
            });
       }

        updateEvents() {
            const appointment = this.appointment;
            this.calendar.removeAllEvents(); // Xóa toàn bộ sự kiện cũ
            this.calendar.addEventSource(appointment); // Thêm danh sách sự kiện mới
        }

        handleSubmitCreateFormModalEvent() {
            this.$createBtnModalCreate.on('click', (event) => {
                event.preventDefault();
                const form = this.$createAppointmentForm;
                if (!$(form).valid()) return;

                var formData = $(form).serialize();
                var url = $(form).attr('action');
                this.onProcess();

                $.ajax({
                    type: 'POST',
                    url: url,
                    data: formData,
                    dataType: 'json',
                    success: (response) => {
                        this.offProcess();
                        const { data } = response;
                        this.setAppointment(data);
                        this.updateEvents();
                        this.$createAppointmentModal.modal('hide');
                        this.clearCreateFormValue();
                        setTimeout(() => alert('Tạo lịch hẹn thành công'), 200);
                    },
                    error: function(error) {
                        this.offProcess();
                        console.log(error);
                    }
                });
            });
        }

        onProcess() {
            $('.loading-container').removeClass('d-none');
        }

        offProcess() {
            $('.loading-container').addClass('d-none');
        }

        clearCreateFormValue() {
            this.$createAppointmentForm.find('input,select').val('');
        }
    }
</script>
@endsection