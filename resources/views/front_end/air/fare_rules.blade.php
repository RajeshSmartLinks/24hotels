
  
  <!-- Content
  ============================================= -->
  <div id="content">
    <section class="container">
      <div class="row">
       
        
        <div class="col-lg-12">
          <!-- Flush Style
			  ============================================= -->
              
              <div class="accordion accordion-flush" id="accordionFlushExample">
                @foreach($FareRuleResp['air:AirFareRulesRsp']['air:FareRule']  as $key => $value)
                    @foreach ($FareRuleResp['air:AirFareRulesRsp']['air:FareRule'][$key]['air:FareRuleLong'] as $ruleKey => $ruleValue)
                    <div class="accordion-item">
                    <h2 class="accordion-header" id="flush-heading-{{$key}}-{{$ruleKey}}">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapse-{{$key}}-{{$ruleKey}}" aria-expanded="false" aria-controls="flush-collapse-{{$key}}-{{$ruleKey}}">{{$ruleValue['@attributes']['CategoryName']}} </button>
                    </h2>
                    <div id="flush-collapse-{{$key}}-{{$ruleKey}}" class="accordion-collapse collapse " aria-labelledby="flush-heading-{{$key}}-{{$ruleKey}}" data-bs-parent="#accordionFlushExample">
                        <div class="accordion-body">{{$ruleValue['@content']}} </div>
                    </div>
                    </div>
            
                    @endforeach
                @endforeach
               
              </div>
              <!-- Flush Style end --> 
        </div>
        
       
        
      </div>
    </section>
  </div>
  <!-- Content end --> 
  

