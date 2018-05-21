
<div class="modal-content">
    <div class="modal-header text-center">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title">Search Results</h4>
    </div>
    <div class="modal-body">
        <div class="modal-content">
            <table class="table table-bordered table-striped table-condensed cf">
                <thead class="cf">
                    <tr>
                        <th>Car Number</th>
                        <th>Member Name</th>
                        <th>Contact Number</th> 
                        <th>&#32;</th>
                    </tr>
                </thead>
                <tbody>
                    @if (empty($result[0]))
                 <tr>
                     <td colspan="4">
                    No Record Found
                    </td>
                 </tr>
                @else
                @foreach($result as $index => $record)
                <tr>
                    <td>{{ $record->RegistrationNo }}</td>
                    <td>{{ $record->Name }}</td>
                    <td>{{ $record->ContactNo }}</td>
                    <td> <a  type="button" class="btn btn-blue btn-block" href="{{ route("newjob",['id' => $record->ID, 'CategoryService' => $CategoryService]) }}"><i class="fa fa-plus"></i> Select</a></td> 
                </tr>

                @endforeach
                @endif

                </tbody>
            </table>

        </div>
    </div><!-- 
    <div class="modal-footer">
        <button data-dismiss="modal" class="btn btn-default" type="button">Cancel</button>
        <button class="btn btn-primary" type="button">Submit</button>
    </div> -->
</div>
