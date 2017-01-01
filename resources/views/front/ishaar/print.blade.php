<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ (app()->getLocale()=="ar") ? "rtl" : "ltr" }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>{{ trans('labels.system_name').' | '.trans('ishaar_setup.print-head-'.$notice->contract->contract_type_id) }}</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendor.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/ajeer.css') }}">
    <link rel="shortcut icon" href="{{ asset('assets/img/favicon.png') }}">
    <link rel="stylesheet"
          href="{{ (app()->getLocale()=="ar") ? asset('assets/css/front-rtl.css') : asset('assets/css/front.css') }}">
</head>
<body>
<div class="container container--mainContainer" role="document">
    <div ui-view="content">
        <div class="aj-page" id="section-to-print">
          <div class="row" style="margin-bottom:7px !important">
            <div class="col-xs-3 text-center">
              <img src="{{ asset('images/n-logo.png') }}"><br>
            </div>
            <h1 class="col-xs-6 text-center">{{trans('ishaar_setup.print-head-'.$notice->contract->contract_type_id)}} </h1>
            <div class="col-xs-3 text-center">
              {!! $barcode !!}
              <p>{{ $notice->id }}</p>
            </div>
          </div>
          <div class="row">
            <div class="col-xs-12 text-center">
              <div class="panel panel-info text-center">
                <div class="panel-heading"> {{trans('ishaar_setup.print-ishaar-expire')}}  {{ $notice->end_date }}</div>
                <div class="panel-body">{{trans('ishaar_setup.print-ishaar-verify')}}</div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-xs-12">
              <span>{{trans('ishaar_setup.print-ishaar-notice')}} </span>
            </div>
          </div>
          <div class="row">
            <div class="col-xs-12">
              <table class="table">
                <tr>
                  <th colspan="4" class="text-center">{{trans('ishaar_setup.print-ishaar-emp-head')}} </th>
                </tr>
                <tr>
                  <th width="20%" scope="row">{{trans('ishaar_setup.form_attributes.name')}}</th>
                  <td width="40%">{{ $notice->hrPool->name }}</td>
                  <th width="20%" scope="row">{{trans('ishaar_setup.form_attributes.job')}}</th>
                  <td width="20%">{{ $notice->hrPool->job->job_name }}</td>
                </tr>
                <tr>
                  <th scope="row">{{trans('ishaar_setup.form_attributes.id_number')}}</th>
                  <td>{{ $notice->hrPool->id_number  }}</td>
                  <th scope="row">{{trans('ishaar_setup.form_attributes.nationality')}}</th>
                  <td>{{ $notice->hrPool->nationality->name }}</td>
                </tr>
                <tr>
                  <th>{{trans('ishaar_setup.form_attributes.gender')}}</th>
                  <td> {!! $notice->hrPool->gender_name !!} </td>
                  <th>{{trans('ishaar_setup.print-ishaar-birthdate')}}</th>
                  <td>@if($notice->hrPool->birth_date){{$notice->hrPool->birth_date->format('Y-m-d')}}@endif </td>
                </tr>
                <tr>
                  <th colspan="4" class="text-center">{{trans('ishaar_setup.print-ishaar-emp-head2')}}</th>
                </tr>
                <tr>
                  <th width="20%" scope="row">{{trans('ishaar_setup.print-ishaar-provider')}} </th>
                  <td>{{ $notice->contract->provider_name }}</td>
                  <th scope="row">{{trans('ishaar_setup.print-ishaar-benf')}}</th>
                  <td>{{ $notice->contract->benf_name }}</td>
                </tr>
                
                <tr>
                  <th scope="row"> {{trans('ishaar_setup.print-ishaar-contractstart')}} </th>
                  <td width="30%">{{ $notice->contract->start_date  }}</td>
                  <th width="20%" scope="row"> {{trans('ishaar_setup.print-ishaar-contractend')}} </th>
                  <td width="30%">{{ $notice->contract->end_date }}</td>
                </tr>
                <tr>
                  <th scope="row">{{trans('ishaar_setup.print-ishaar-map-head')}}</th>
                  <td colspan="3">
                    {{$notice->contract->contractLocations[0]->region->name}}
                    <br>
                    <img src="//maps.googleapis.com/maps/api/staticmap?center={{$notice->contract->contractLocations[0]->region->name}}&amp;zoom=16&amp;size=450x225&amp;maptype=roadmap&amp;markers=color:red%7Ccolor:red%7C{{$notice->contract->contractLocations[0]->region->name}}&amp;sensor=false">

                  </td>
                </tr>
                <!-- TODO:  all other contract location goes here-->
                <tr>
                  <th scope="row">{{trans('ishaar_setup.form_attributes.work_areas')}} </th>
                  <td colspan="3">
                    <ul>
                     @foreach($notice->contract->contractLocations as $cc)
                     <li> {!! nl2br($cc->desc_location) !!} </li>
                    @endforeach
                    </ul>
                  </td>

              </table>
            </div>
          </div>
          <div class="row aj-agreement">
            <div class="col-xs-12">
              <h4 class="text-center">
                <ins>{{trans('ishaar_setup.print-ishaar-iqrar')}}</ins>
              </h4>
              <ul>
                {!! trans('ishaar_setup.print-ishaar-iqrarsyntax') !!}
              </ul>
            </div>
          </div>
          <div class="row">
            <div class="col-xs-6 text-center"> {{trans('ishaar_setup.print-ishaar-assign')}}</div>
            <div class="col-xs-6 text-center"> {{trans('ishaar_setup.print-ishaar-khatm')}}</div>
          </div>
          <div class="row text-center" style="margin-top: 40px">
            <h4>{{trans('ishaar_setup.print-ishaar-service')}}</h4>
          </div>
        </div>
    </div>
</div>
<script>window.print();</script>
</body>
</html>