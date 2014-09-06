<?php namespace Protestr\Validators;
 
use Illuminate\Support\ServiceProvider;
 
class ValidationServiceProvider extends ServiceProvider {
 
  public function register(){}
 
  public function boot()
  {
    $this->app->validator->resolver(function($translator, $data, $rules, $messages)
    {
      return new CustomValidators($translator, $data, $rules, $messages);
    });
  }
 
}
