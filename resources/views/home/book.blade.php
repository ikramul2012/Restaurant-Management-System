<div class="container-fluid has-bg-overlay text-center text-light has-height-lg middle-items" id="book-table">
    <div class="">
        <h2 class="section-title mb-5">BOOK A TABLE</h2>

        <form action="{{url('book_table')}}"method ="Post">


        @csrf
        <div class="row mb-5">
            <div class="col-sm-6 col-md-3 col-xs-12 my-2">
                <input type="number" id="phone" class="form-control form-control-lg custom-form-control" name="phone" placeholder="Phone Number">
            </div>
            <div class="col-sm-6 col-md-3 col-xs-12 my-2">
                <input type="number" id="guests" class="form-control form-control-lg custom-form-control"name="n_guest" placeholder="NUMBER OF GUESTS" max="20" min="0">
            </div>
            <div class="col-sm-6 col-md-3 col-xs-12 my-2">
                <input type="time" id="time" class="form-control form-control-lg custom-form-control" name="time" placeholder="Time">
            </div>
            <div class="col-sm-6 col-md-3 col-xs-12 my-2">
                <input type="date" id="date" class="form-control form-control-lg custom-form-control" name="date" placeholder="Date">
            </div>
            <div class="col-sm-6 col-md-3 col-xs-12 my-2">
                <input type="text" id="advance" class="form-control form-control-lg custom-form-control" name="advance" placeholder="10% Advance Payment" readonly>
            </div>
        </div>
        <input type="submit" class="btn btn-lg btn-primary" id="rounded-btn" value="Book Table"
        <br>
        <button id="advance-payment-btn" class="btn btn-lg btn-success mt-3" style="display: none;">10% Advance Payment</button>
        </form>
    </div>
</div>

<script>
    document.getElementById("date").addEventListener("change", function() {
        const selectedDate = new Date(this.value);
        const today = new Date();
        today.setMonth(today.getMonth() + 1); // One month from today

        if (selectedDate >= today) {
            document.getElementById("advance-payment-btn").style.display = "block";
        } else {
            document.getElementById("advance-payment-btn").style.display = "none";
        }
    });
</script>