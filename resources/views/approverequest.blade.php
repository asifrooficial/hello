<x-layout>
<div>
    <div class="container py-md-1 container--narrow">
        <p class="ml-2">
        <h2><strong>Approve Regears</strong></h2>
        </p>

        <h2>
            <form class="ml-0 d-inline" action="{{ route('searchRequest') }}" method="GET">
                <button href="#" class="btn btn-primary">Search</button>
            </form>
            <form class="ml-0 d-inline" action="{{ route('processRequests') }}" method="POST">
                <button type="submit" class="btn btn-primary">Process Requests</button>
                <input type="Reset" class="btn btn-secondary" />
                
        </h2>
        
        {{ $requests->links() }}
        <div class="list-group">
            
            @foreach ($requests as $request)
                @csrf
                <label @class([
                    'list-group-item',
                    'list-group-item-danger' => $request->isApproved == 2,
                    'list-group-item-success' => $request->isApproved == 3,
                    'list-group-item-action',
                ]) {{ 'for="includeCheckBox"' . $loop->index }} >
                 

                    
                        <strong>{{ $request->username . ' ' }}</strong>

                        @if ($request->isBomb == 0)
                            
                        @else
                            <strong class="text-danger">Bomb Squad</strong>
                        @endif

                        <br>
                        Slain by <strong>{{ $request->killer . ' ' }}<em>{{ $request->killerGuild }}</em></strong> on
                        {{ date('m.d.Y h:i', strtotime($request->timeKilled)) }}
                        <br>
                    
                        @if ($request->offHand)
                            <img href="#" style="width: 60px; height: 60px"
                                src="https://render.albiononline.com/v1/item/{{ $request->offHand }}">
                        @else
                        @endif

                        @if ($request->mainHand)
                            <img href="#" style="width: 60px; height: 60px"
                                src="https://render.albiononline.com/v1/item/{{ $request->mainHand }}" title="{{ $request->mainHand }}">
                        @else
                        @endif

                        @if ($request->head)
                            <img href="#" style="width: 60px; height: 60px"
                                src="https://render.albiononline.com/v1/item/{{ $request->head }}">
                        @else
                        @endif

                        @if ($request->armor)
                            <img href="#" style="width: 60px; height: 60px"
                                src="https://render.albiononline.com/v1/item/{{ $request->armor }}">
                        @else
                        @endif

                        @if ($request->shoes)
                            <img href="#" style="width: 60px; height: 60px"
                                src="https://render.albiononline.com/v1/item/{{ $request->shoes }}">
                        @else
                        @endif

                        @if ($request->cape)
                            <img href="#" style="width: 60px; height: 60px"
                                src="https://render.albiononline.com/v1/item/{{ $request->cape }}">
                        @else
                        @endif

                        @if ($request->mount)
                            <img href="#" style="width: 60px; height: 60px"
                                src="https://render.albiononline.com/v1/item/{{ $request->mount }}">
                        @else
                        @endif
                    <br>

                    @if ($request->isApproved == 1)
                      <!--  <div class="form-check">
                            <input type="checkbox" class="form-check-input" value={{ $request->id }}
                                name={{ 'approvedId[]' }} {{ 'id="includeCheckBox"' . $loop->index }}>
                            <label class="form-check-label" {{ 'for="includeCheckBox"' . $loop->index }}>
                                <strong>Include</strong>
                            </label>
                        </div>

                        <div class="form-check" id="denyCheckBox">
                            <input type="checkbox" class="form-check-input" value={{ $request->id }}
                                name={{ 'denyId[]' }} {{ 'id="denyCheckBox"' . $loop->index }}>
                            <label class="form-check-label" {{ 'for="denyCheckBox"' . $loop->index }}>
                                <strong>Deny</strong>
                            </label>
                        </div> -->

                        <div class="form-check">
                            <input class="form-check-input" type="radio" name={{ "requests[$loop->index]" }} id={{ "radio1".$request->id }} value={{ $request->id.",approved" }}>
                            
                            
                            <label class="form-check-label" for={{ "radio1".$request->id }}>
                              Approve
                            </label>
                          </div>
                          <div class="form-check">
                            <input class="form-check-input" type="radio" name={{ "requests[$loop->index]" }} id={{ "radio2".$request->id }} value={{ $request->id.",denied" }}>
                            <label class="form-check-label" for={{ "radio2".$request->id }}>
                              Deny
                            </label>
                          </div>
                        
                    @else
                    @endif
                    <em class="font-weight-lighter">(Request ID: {{ $request->id }})</em>
                </label>
                
            @endforeach
                
            

            </form>
            
        </div>
        <br>
        {{ $requests->links() }}
</div>
</x-layout>