@extends('_layouts.admin')

@section('title', 'Dashboard')

@section('styles')

@endsection

@section('content')
    <h3></i>SUBMIT ASSIGNMENT</h3>
    <div class="row mt">
        <div class="col-lg-12">
            <div class="panel panel-warning">
                <div class="panel-heading">
                    <h3 class="panel-title">SUBMIT ASSIGNMENT</h3>
                </div>
                <div class="panel-body">
                    <form action="{{ route('assignments.store') }}" method="POST"  enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <div class="form-group clearfix">
                            <label for="assignment" class="col-sm-2 control-label required">Assignment</label>
                            <div class="col-sm-6">
                                <input type="file" class="form-control" id="assignment" name="assignment" placeholder="File" required value="{{ $assignment->title }}" disabled="disabled">
                            </div>
                        </div>
                        <div class="form-group clearfix">
                            <label for="upload_file" class="col-sm-2 control-label required">File</label>
                            <div class="col-sm-6">
                                <input type="file" class="form-control" id="upload_file" name="upload_file" placeholder="File" required>
                            </div>
                        </div>
                        <div class="form-group clearfix">
                            <label for="extra" class="col-sm-2 control-label">Extra</label>
                            <div class="col-sm-6">
                                <textarea type="text" class="form-control" id="extra" name="extra" rows="5" placeholder="Instructions"></textarea>
                            </div>
                        </div>
                        <div class="form-group clearfix">
                            <div class="col-md-offset-2 col-sm-6">
                                <input type="submit" class="btn btn-success btn-lg" value="Submit">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('modal')

@endsection


@section('scripts')
<script src="/js/select2.full.min.js"></script>
<script>
    {{-- $('#lecturers').select2(); --}}
</script>
@endsection
