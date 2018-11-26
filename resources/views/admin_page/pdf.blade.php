<div class="row">
<table id="chaptersdb" class="table table-striped table-bordered dt-responsive nowrap" style="width:100%">
    <thead class="thead-dark">
        <tr>
            <th>Chapter</th>
            <th>Chapter Code</th>
            <th>Region</th>
            <th>Short Name</th>
            <th>Active</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($chapters as $o)
        <tr>
            <td>{{$o->chapter}}</td>
            <td>{{$o->chap_code}}</td>
            <td>{{$o->region}}</td>
            <td>{{$o->shortname}}</td>
            <td>{{$o->active}}</td>
            
        </tr>
        @endforeach
    </tbody>
</table>      
</div>