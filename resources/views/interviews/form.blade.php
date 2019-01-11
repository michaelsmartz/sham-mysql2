
        <div class="col-md-12">
            <label for="interviewType">Select Interview Type</label>
            <select v-model="interviewType" class='form-control'>
                <option disabled value="">Please select one</option>
                <option> Phone Interview</option>
                <option> Structured Interview </option>
                <option> Problem Solving Interview </option>
                <option> Skype Interview </option>
            </select>
        </div>
        <div class="col-md-12">
            <label for="comments">Schedule Comments</label>
            <textarea class="form-control"></textarea>
        </div>
        <div class="col-md-6">
            <label for="from">From</label>
            <input
                    id="from"
                    class='form-control datepicker'
                    v-model="current.from"
                    name="from"
                    type="text"
            >
        </div>
        <div class="col-md-6">
            <label for="to">To</label>
            <input
                    id="to"
                    class='form-control datepicker'
                    v-model="current.to"
                    name="to"
                    type="text"
            >
        </div>
        <div class="col-md-12">
            <label for="interviewers">Interviewer(s)</label>
            <input
                    id="interviewers"
                    class='form-control'
                    v-model="current.interviewers"
                    type="text"
                    name="interviewers"
                    multiple
            >
        </div>
        <div class="col-md-12">
            <label for="location">Location</label>
            <input
                    id="location"
                    class='form-control'
                    v-model="current.location"
                    type="text"
                    name="location"
            >
        </div>
