<x-layout>
    <div class="container py-md-5 container--narrow">
        <x-nameplate />
        <p class="ml-2">
        <h2><strong>Recent Deaths</strong></h2>
        </p>
        <h2>
            <form class="ml-2 d-inline" action="{{ route('makeRequest') }}" method="POST">
                <button type="submit" class="btn btn-primary">Request Regear</button>
                @csrf
                <input type="Reset" class="btn btn-secondary" />
        </h2>

        <div class="list-group">
            @foreach ($posts as $post)
                @csrf
                <label @class([
                    'list-group-item',
                    'list-group-item list-group-item-action' => $post->isApproved == 0,
                    'list-group-item-warning' => $post->isApproved == 1,
                    'list-group-item list-group-item-success' => $post->isApproved == 3,
                    'list-group-item list-group-item-danger' => $post->isApproved == 2,
                ]) {{ 'for="defaultCheck"' . $loop->index }}>

                    <p>Slain by <strong>{{ $post->killer . ' ' }}<em>{{ $post->killerGuild }}</em></strong> on
                        {{ date('m.d.Y h:i', strtotime($post->timeKilled)) }}
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
                                src="https://render.albiononline.com/v1/item/{{ $post->mainHand }}"
                                title="{{ $post->mainHand }}">
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


                        @if (empty($post->bag) &&
                                empty($post->offHand) &&
                                empty($post->mainHand) &&
                                empty($post->head) &&
                                empty($post->armor) &&
                                empty($post->shoes) &&
                                empty($post->cape) &&
                                empty($post->mount))
                            <br><em>Died naked like a baby!</em>
                        @else
                            @if ($post->isApproved == 0)
                                <div class="btn-group btn-group-toggle" data-toggle="buttons">
                                    <label class="btn btn-outline-danger">
                                        <input type="checkbox" name={{ 'mainOrBomb[]' }} value={{ $post->eventId }}>
                                        Bomb Squad
                                    </label>
                                </div>
                                <br><br>
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" value={{ $post->eventId }}
                                        name={{ 'eventId[]' }} {{ 'id="defaultCheck"' . $loop->index }}>
                                    <label class="form-check-label" {{ 'for="defaultCheck"' . $loop->index }}>
                                        <strong>Include in Request</strong>
                                    </label>
                                </div>

                            @elseif ($post->isBomb == 0)
                            @else
                                <br><strong class="text-danger">Bomb Squad</strong>
                            @endif
                                
                            
                        @endif




                    </p>





                </label>
            @endforeach
            </form>
        </div>
    </div>
</x-layout>
