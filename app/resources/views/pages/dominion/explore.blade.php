@extends('layouts.master')

@section('page-header', 'Explore')

@section('content')
    <div class="row">

        <div class="col-sm-12 col-md-6">
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title"><i class="fa fa-search"></i> Explore</h3>
                    <a href="{{ route('dominion.advisors.land') }}" class="pull-right">Land Advisor</a>
                </div>
                <div class="box-body">
                    <p>Cost per acre:</p>
                    <p>
                        Platinum: {{ number_format($landCalculator->getExplorationPlatinumCost()) }}<br>
                        Draftees: {{ number_format($landCalculator->getExplorationDrafteeCost()) }}
                    </p>
                    <p>You have {{ number_format($selectedDominion->resource_platinum) }} platinum and {{ number_format($selectedDominion->military_draftees) }} draftees.</p>
                    <p>You can afford to explore for {{ number_format($landCalculator->getExplorationMaxAfford()) }} acres of land at that rate.</p>
                </div>
            </div>
        </div>

        <div class="col-sm-12 col-md-6">
            <div class="box">
                <form action="{{ route('dominion.explore') }}" method="post" role="form">
                    {!! csrf_field() !!}
                    <div class="box-body">
                        <table class="table">
                            <colgroup>
                                <col>
                                <col width="100">
                                <col width="100">
                                <col width="100">
                            </colgroup>
                            <thead>
                                <tr>
                                    <th>Terrain</th>
                                    <th class="text-center">Owned</th>
                                    <th class="text-center">Exploring</th>
                                    <th class="text-center">Explore For</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($landHelper->getLandTypes() as $landType)
                                    <tr>
                                        <td>{{ ucfirst($landType) }}</td>
                                        <td class="text-center">
                                            {{ number_format($selectedDominion->{'land_' . $landType}) }}
                                            <small>
                                                ({{ number_format((($selectedDominion->{'land_' . $landType} / $landCalculator->getTotalLand()) * 100), 1) }}%)
                                            </small>
                                        </td>
                                        <td class="text-center">{{ number_format($dominionQueueService->getExplorationQueueTotalByLand($landType)) }}</td>
                                        <td class="text-center">
                                            <input type="number" name="explore[{{ $landType }}]" class="text-center" placeholder="0" min="0" max="{{ $landCalculator->getExplorationMaxAfford() }}" value="{{ old('explore.' . $landType) }}">
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="box-footer">
                        <button type="submit" class="btn btn-primary">Explore</button>
                    </div>
                </form>
            </div>
        </div>

    </div>
@endsection
