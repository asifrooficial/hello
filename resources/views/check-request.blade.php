<x-layout>
    <div class="container py-md-5 container--narrow">
        <x-nameplate />
        <p class="ml-2">
        <h2><strong>Edit Requests</strong></h2>
        </p>
        <p class="ml-2"><strong class="text-success">Green</strong> - Regear been approved
            <br><strong class="text-warning">Yellow</strong> - Regear has been requested
            <br><strong class="text-danger">Red</strong> - Regear has been denied
        </p>
        <!-- begin list -->
        {{ $posts->links() }}
        <div class="list-group">

            @forelse ($posts as $post)
                <label @class([
                    'list-group-item',
                    'list-group-item-warning' => $post->isApproved == 1,
                    'list-group-item-danger'=> $post->isApproved == 2,
                    'list-group-item-success' => $post->isApproved == 3,
                ])>
                    <p>
                        Slain by <strong>{{ $post->killer . ' ' }}<em>{{ $post->killerGuild }}</em></strong> on
                        {{ date('m.d.Y h:i', strtotime($post->timeKilled)) }} (Request ID: {{ $post->id }})
                    <br>
                        
                        @if ($post->bag)
                            <img href="#" style="width: 75px; height: 75px"
                                src="https://render.albiononline.com/v1/item/{{ $post->bag }}">
                        @else
                        @endif

                        @if ($post->offHand)
                            <img href="#" style="width: 75px; height: 75px"
                                src="https://render.albiononline.com/v1/item/{{ $post->offHand }}">
                        @else
                        @endif

                        @if ($post->mainHand)
                            <img href="#" style="width: 75px; height: 75px"
                                src="https://render.albiononline.com/v1/item/{{ $post->mainHand }}">
                        @else
                        @endif

                        @if ($post->head)
                            <img href="#" style="width: 75px; height: 75px"
                                src="https://render.albiononline.com/v1/item/{{ $post->head }}">
                        @else
                        @endif

                        @if ($post->armor)
                            <img href="#" style="width: 75px; height: 75px"
                                src="https://render.albiononline.com/v1/item/{{ $post->armor }}">
                        @else
                        @endif

                        @if ($post->shoes)
                            <img href="#" style="width: 75px; height: 75px"
                                src="https://render.albiononline.com/v1/item/{{ $post->shoes }}">
                        @else
                        @endif

                        @if ($post->cape)
                            <img href="#" style="width: 75px; height: 75px"
                                src="https://render.albiononline.com/v1/item/{{ $post->cape }}">
                        @else
                        @endif

                        @if ($post->mount)
                            <img href="#" style="width: 75px; height: 75px"
                                src="https://render.albiononline.com/v1/item/{{ $post->mount }}">
                        @else
                        @endif
                    
                        <br>
                    
                        @if ($post->isBomb == 0)
                            
                        @else
                            Tagged as <strong class="text-danger">Bomb Squad</strong>
                        @endif
                    </p>

                    @if ($post->isApproved == 1)
                        <div class="btn-group btn-group-toggle">
                            <form action="/profile/edit-requests/change-tag" method="GET">
                                @if ($post->isBomb == 0)
                                    <label>
                                        <button type="submit" class="btn btn-primary" name="changeTag[]"
                                            value="{{ $post->eventId }}"> Change Tag </button>
                                        <input type="hidden" name="bombValue[]" value="{{ $post->isBomb }}" />
                                    </label>
                                @else
                                    <label>
                                        <button type="submit" class="btn btn-primary" name="changeTag[]"
                                            value="{{ $post->eventId }}"> Change Tag </button>
                                        <input type="hidden" name="bombValue[]" value="{{ $post->isBomb }}" />
                                    </label>
                                @endif
                            </form>
                        </div>
                        <div class="btn-group btn-group-toggle">
                            <form action="/profile/edit-requests/delete" method="GET">
                                <label>
                                    <button type="submit" class="btn btn-danger" name="getRid[]"
                                        value="{{ $post->eventId }}"> Cancel Request </button>
                                </label>
                            </form>
                        </div>
                    @elseif ($post->isApproved == 2)
                        <em class="font-weight-lighter">Request Denied on {{ date('m.d.Y h:i', strtotime($post->updated_at)) }}</em> (Request ID: {{ $post->id }})
                    @elseif ($post->isApproved == 3)
                        <em class="font-weight-lighter">Request Approved on {{ date('m.d.Y h:i', strtotime($post->updated_at)) }}</em>
                    @endif
                    


                    

                </label>

                
            @empty
                <label class="list-group-item list-group-item-success">
                    <strong>No regear requests found </strong>dollar, dollar bill, y'all - saving the guild some sweet
                    silver
                </label>
            @endforelse


        </div>
        <!-- end list -->
        {{ $posts->links() }}
    </div>
</x-layout>
