<div>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Sale Setting
                    </div>
                    <div class="panel-body">
                        @if (Session::has('success_message'))
                            <div class="alert alert-success">
                                {{Session::get('success_message')}}
                            </div>
                        @endif
                        <form class="form-horizontal" wire:submit.prevent="updateSale">
                            <div class="form-group">
                                <label for="" class="col-md-4 control-label">Status</label>
                                <div class="col-md-4">
                                    <select class="form-control" wire:model="status">
                                        <option value="0">Inactive</option>
                                        <option value="1">Active</option>
                                    </select>
                                    @error('status')<span class="text-red-600">{{$message}}</span>@enderror
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="" class="col-md-4 control-label">Sale Date</label>
                                <div class="col-md-4">
                                    <input type="text" class="form-control input-md" id="sale_date" placeholder="YYYY/MM/DD H:M:S" wire:model="sale_date">
                                    @error('sale_date')<span class="text-red-600">{{$message}}</span>@enderror
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="" class="col-md-4 control-label"></label>
                                <div class="col-md-4">
                                    <button type="submit" class="btn btn-primary">Save</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
    <script>
        $(function(){
            $('#sale_date').daterangepicker({
                "singleDatePicker": true,
                "timePicker": true,
                "showDropdowns": true,
                "timePicker24Hour": true,
                "locale":{
                    "format" : "YYYY-MM-DD HH:mm:ss",
                }
            }).on('apply.daterangepicker',function(ev){
                var data = $('#sale_date').val();
                @this.set('sale_date',data);
            });
        });
    </script>
@endpush
