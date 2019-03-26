@extends('portal-index')

@section('title','Vuejs Test')
@section('content')
    <section id="test-zone">
        <date-picker></date-picker>
        <br>
        <input type="text" class="form-control">
        <br>
        <div id="table">
            <wenzhixin-bs-table></wenzhixin-bs-table>
        </div>
    </section>
@endsection

@section('scripts')
    <script src="{{asset('js/vue-component-test.js')}}"></script>
@endsection