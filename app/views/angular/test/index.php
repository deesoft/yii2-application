<div class="branch-index">
    <div class="btn-group">
        <a href="#/" class="btn btn-success btn-sm"><i class="fa fa-plus-square"></i>&nbsp;Create</a>
    </div>    
    <div class="box box-info">
        <div class="box-body no-padding">
            <div >
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th><a data-sort="code" href="#/">Code</a></th>
                            <th><a data-sort="name" href="#/">Name</a></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr data-key="{{product.id}}" ng-repeat="(key,product) in data.rows">
                            <td><a href="#/{{product.id}}">{{key+1}}</a></td>
                            <td>{{product.code}}</td>
                            <td>{{product.name}}</td>
                        </tr>
                    </tbody>
                </table>
            </div>        
        </div>
    </div>
</div>