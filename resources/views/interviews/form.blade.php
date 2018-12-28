
        <div class="col-md-6">
            <label for="interviewType">Select Interview Type</label>
            <select v-model="interviewType" class='form-control'>
                <option disabled value="">Please select one</option>
                <option v-for="interviewType in interviewTypes" :value="interviewType">@{{interviewType}}</option>
            </select>
        </div>
        <div class="col-md-6">
            <label for="candidateName">Candidate Name</label>
            <input
                    id="candidateName"
                    class='form-control'
                    v-model="current.name"
                    type="text"
                    name="candidateName"
            >
        </div>
        <div class="col-md-6">
            <label for="comments">Schedule Comments</label>
            <input
                    id="comments"
                    class='form-control'
                    v-model="current.comments"
                    type="text"
                    name="comments"
            >
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
        <div class="col-md-6">
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
        <div class="col-md-6">
            <label for="location">Location</label>
            <input
                    id="location"
                    class='form-control'
                    v-model="current.location"
                    type="text"
                    name="location"
            >
        </div>
        <div id="date-picker"> </div>
