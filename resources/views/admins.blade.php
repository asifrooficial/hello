<!DOCTYPE html>
<html lang="en">
<x-layout>
    <div>
        <!-- start navbar -->
        <div class="container py-md-5 container--narrow">
            <ul class="nav nav-tabs">
                <li class="nav-item">
                    <a class="nav-link active" href="#">Give Role</a>
                </li>
            </ul>
        </div>
        <!-- end navbar -->

        <!-- start body -->
        <div class="container py-md-2 container--narrow">
            <form action="/admins-only/search" method="GET">
                <div class="form-group">
                    <label for="gmName">Username</label>
                    <input type="text" class="form-control" id="gmName" name="gmName">
                    <small id="gmNameHelp" class="form-text text-muted">Search Albion Character Name</small>
                </div>
                <button type="submit" class="btn btn-primary">Search</button>
            </form>
        </div>

        <div class="container py-md-5">
            <table class="table ">
                <thead>
                    <tr>
                        <th scope="col">IGN</th>
                        <th scope="col">Player ID</th>
                        <th scope="col">Guild</th>
                        <th scope="col">Role</th>
                        <th scope="col"></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                        <tr>
                            <th scope="row">{{ $user->username }}</th>
                            <td>{{ $user->playerId }}</td>
                            <td>{{ $user->guildName }}</td>
                            <td>{{ $user->role_name }}</td>
                            <td>
                                <form action="{{ route('give-role') }}" method="POST">
                                    @csrf
                                    <div class="form-check form-check-inline">
                                        <input type="hidden" name="userId" value={{ $user->id }} />
                                        <input class="form-check-input" type="radio" name="role_id" id="inlineRadio1" value="3">
                                        <label class="form-check-label" for="inlineRadio1">GM</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="role_id" id="inlineRadio2" value="2">
                                        <label class="form-check-label" for="inlineRadio2">Officer</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="role_id" id="inlineRadio3" value="1">
                                        <label class="form-check-label" for="inlineRadio3">User</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <button type="submit" class="btn btn-primary mb-2">Submit</button>
                                        </div>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <!-- end of body -->
    </div>
</x-layout>

</html>
