@extends('layouts.home.index')
@section('content')
@php
    use App\Models\ScheduleBooked;
    use Carbon\Carbon;
@endphp
  <div class="container pt-4">
    <section id="jadwal">
      <div class="section-title mt-3">
        <h2>Jadwal Praktik</h2>
      </div>
      <div class="card">
        <div class="table-responsive text-nowrap">
          <table class="table">
            <thead>
              <tr>
                <th>Hari \ Jam Praktik</th>
                @foreach ($schedule_detail as $item)
                  <th><strong>{{ date('H:i',strtotime($item->time)) }}</strong></th>
                @endforeach
              </tr>
            </thead>
            <tbody class="table-border-bottom-0">
              @foreach ($schedule as $jadwal)
                <tr>
                  <td><strong>{{ getDayIndo($jadwal->day) }}</strong></td>
                  @foreach ($schedule_detail as $item)
                    @php
                          
                        $startDate = Carbon::now()->startOfWeek(Carbon::MONDAY);
                        $endDate = Carbon::now()->endOfWeek(Carbon::SUNDAY);
                        // @dd([$startDate,$endDate]);
                        $data = ScheduleBooked::whereRaw("date >= '".$startDate."' AND date <= '".$endDate."' AND time = '".date('H:i',strtotime($item->time))."' AND (DAYOFWEEK(date)-1) = '$jadwal->day'")->where(function($query){
                          $query->whereRaw("status != 'REJECT' AND status != 'CANCEL'");
                        })->first();

                    @endphp
                    @if ($data)
                      <td><span class="badge bg-label-success">Booked</span></td>
                    @else
                    <td><span class="badge bg-label-secondary">Avail</span></td>
                    @endif
                  @endforeach
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
  
    </section>
  </div>
@endsection