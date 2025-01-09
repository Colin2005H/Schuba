@extends('head')

@section('title','Liste Membres')

@section('content')

<h1 class="font-bold text-[#004B85] text-center text-2xl m-4">Liste des élèves</h1>
<div class="w-3/4 max-w-5xl scalable overflow-y-scroll mb-16 max-h-96 bg-white shadow-lg rounded-lg">
    <table class="min-w-full table-auto">
      <thead>
        <tr class="bg-gray-200">
          <th class="text-center py-4 px-6">NOM</th>
          <th class="text-center py-4 px-6">PRENOM</th>
          <th class="text-center py-4 px-6">NIVEAU</th>
          <th class="text-center py-4 px-6">MAIL</th>
        </tr>
      </thead>
      <tbody>
         @foreach ($studentList as $item)
          @if($item->UTI_SUPPRIME==0)

                  <td class="text-center py-4 px-6">{{$item->UTI_NOM}}</td>
                  <td class="text-center py-4 px-6">{{$item->UTI_PRENOM}}</td>
                  @switch($item->UTI_NIVEAU)
                      @case(0)
                          <td class="text-center py-4 px-6">PAS DE NIVEAU</td>
                          @break
                      @case($item->UTI_NIVEAU > 0 && $item->UTI_NIVEAU < 5 )
                          <td class="text-center py-4 px-6">N{{$item->UTI_NIVEAU}}</td>
                          @break
                      @case(5)
                          <td class="text-center py-4 px-6">MF1</td>
                          @break
                      @case(6)
                          <td class="text-center py-4 px-6">MF1</td>
                          @break

                  @endswitch

                  <td class="text-center py-4 px-6">{{$item->UTI_MAIL}}</td>

              </tr>

            @endif
        @endforeach

      </tbody>
    </table>
</div>

<h1 class="font-bold text-[#004B85] text-center text-2xl m-4">Liste des initiateurs</h1>
<div class="w-3/4 max-w-5xl scalable overflow-y-scroll max-h-96 bg-white shadow-lg rounded-lg">
    <table class="min-w-full table-auto">
        <thead>
          <tr class="bg-gray-200">
            <th class="text-center py-4 px-6">NOM</th>
            <th class="text-center py-4 px-6">PRENOM</th>
            <th class="text-center py-4 px-6">NIVEAU</th>
            <th class="text-center py-4 px-6">MAIL</th>
          </tr>
        </thead>
        <tbody>
           @foreach ($initiatorList as $item)
            @if($item->UTI_SUPPRIME==0)

                    <td class="text-center py-4 px-6">{{$item->UTI_NOM}}</td>
                    <td class="text-center py-4 px-6">{{$item->UTI_PRENOM}}</td>
                    @switch($item->UTI_NIVEAU)
                        @case(0)
                            <td class="text-center py-4 px-6">PAS DE NIVEAU</td>
                            @break
                        @case($item->UTI_NIVEAU > 0 && $item->UTI_NIVEAU < 5 )
                            <td class="text-center py-4 px-6">N{{$item->UTI_NIVEAU}}</td>
                            @break
                        @case(5)
                            <td class="text-center py-4 px-6">MF1</td>
                            @break
                        @case(6)
                            <td class="text-center py-4 px-6">MF1</td>
                            @break

                    @endswitch

                    <td class="text-center py-4 px-6">{{$item->UTI_MAIL}}</td>

                </tr>

              @endif
          @endforeach

        </tbody>
      </table>
  </div>

@endsection
