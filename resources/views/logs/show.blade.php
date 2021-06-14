
@extends('layouts.app') 
    
@section('content')
<link rel="stylesheet" href="{{ asset('css/tickets.css') }} ">

<div class="container">
    		
    <div class="row">
        <div class="col-md-12">
            <div class="page-header">
              <h1>Helpline/Hotline Report #1</h1>
            </div>
            <ul class="timeline">
                <li class="timeline-item">
                    <div class="timeline-badge info"><i class="glyphicon glyphicon-off"></i></div>
                    <div class="timeline-panel">
                        <div class="timeline-heading">
                            <h4 class="timeline-title">CREATE</h4>
                            <h5>Status: New - Hotline</h5>
                            <p><small class="text-muted"><i class="glyphicon glyphicon-time"></i> March 12, 2020</small></p>
                        </div>
                        <div class="timeline-body">
                            <ul>
                                <li>Submission Type: email</li>
                                <li>Resource Type: chatroom</li>
                                <li>User Opened: admin</li>
                                <li>User Assigned: admin</li>
                            </ul>
                     </div>
                     <br>
                    <button class="btn btn-primary">Show more</button>
                    </div>
                </li>

                <li class="timeline-item">
                    <div class="timeline-badge info"><i class="glyphicon glyphicon-off"></i></div>
                    <div class="timeline-panel">
                        <div class="timeline-heading">
                            <h4 class="timeline-title">CREATE</h4>
                            <h5>Status: New - Hotline</h5>
                            <p><small class="text-muted"><i class="glyphicon glyphicon-time"></i> March 12, 2020</small></p>
                        </div>
                        <div class="timeline-body">
                            <ul>
                                <li>Submission Type: email</li>
                                <li>Resource Type: chatroom</li>
                                <li>User Opened: admin</li>
                                <li>User Assigned: admin</li>
                            </ul>
                            
                     </div>
                     <br>
                    <button class="btn btn-primary">Show more</button>
                    </div>
                </li>
                

                <li class="timeline-item"></li>


                
                {{-- <li class="timeline-item">
                    <div class="timeline-badge"><i class="glyphicon glyphicon-check"></i></div>
                    <div class="timeline-panel">
                        <div class="timeline-heading">
                            <h4 class="timeline-title">Mussum ipsum cacilds 3</h4>
                            <p><small class="text-muted"><i class="glyphicon glyphicon-time"></i> 11 hours ago via Twitter</small></p>
                        </div>
                        <div class="timeline-body">
                            <p>Mussum ipsum cacilds, vidis litro abertis. Consetis adipiscings elitis. Pra lá , depois divoltis porris, paradis. Paisis, filhis, espiritis santis. Mé faiz elementum girarzis, nisi eros vermeio, in elementis mé pra quem é amistosis quis leo. Manduma pindureta quium dia nois paga. Sapien in monti palavris qui num significa nadis i pareci latim. Interessantiss quisso pudia ce receita de bolis, mais bolis eu num gostis.</p>
                            <p>Mussum ipsum cacilds, vidis litro abertis. Consetis adipiscings elitis. Pra lá , depois divoltis porris, paradis. Paisis, filhis, espiritis santis. Mé faiz elementum girarzis, nisi eros vermeio, in elementis mé pra quem é amistosis quis leo. Manduma pindureta quium dia nois paga. Sapien in monti palavris qui num significa nadis i pareci latim. Interessantiss quisso pudia ce receita de bolis, mais bolis eu num gostis.</p>
                            
                        </div>
                    </div>
                </li> --}}
                {{-- <li class="timeline-item">
                    <div class="timeline-badge"><i class="glyphicon glyphicon-check"></i></div>
                    <div class="timeline-panel">
                        <div class="timeline-heading">
                            <h4 class="timeline-title">Mussum ipsum cacilds 4</h4>
                            <p><small class="text-muted"><i class="glyphicon glyphicon-time"></i> 11 hours ago via Twitter</small></p>
                        </div>
                        <div class="timeline-body">
                            <p>Mussum ipsum cacilds, vidis litro abertis. Consetis adipiscings elitis. Pra lá , depois divoltis porris, paradis. Paisis, filhis, espiritis santis. Mé faiz elementum girarzis, nisi eros vermeio, in elementis mé pra quem é amistosis quis leo. Manduma pindureta quium dia nois paga. Sapien in monti palavris qui num significa nadis i pareci latim. Interessantiss quisso pudia ce receita de bolis, mais bolis eu num gostis.</p>
                        </div>
                    </div>
                </li> --}}
            </ul> 
        </div>
    </div>
</div>
@endsection
