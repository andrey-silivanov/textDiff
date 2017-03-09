@extends('app')
@section('main-content')
    <div id="compare" v-cloak>
        <div class="container content">
            <form action="{{route('compare')}}" method="post">
                {{ csrf_field() }}
                <div class="row">
                    <div class="col-xs-6">
                    <textarea name="originalText" id="first_text" v-model="originalText" rows="20">
                    </textarea>
                    </div>
                    <div class="col-xs-6">
                        <div v-if="showResult" id="result">
                                <span v-for="one in result.data" v-bind:class="one.type"
                                      v-bind:data-hover="one.origin">
                                @{{ one.value + '.' }}
                            </span>
                        </div>
                        <textarea v-else name="newText" v-model="newText" id="last_text" rows="20">
                        </textarea>
                    </div>
                </div>
                <div class="row button-block">
                    <button class="btn btn-danger" v-on:click.prevent="clear"> Очистить </button>
                    <button class="btn btn-warning" :disabled="!showResult" v-on:click.prevent="back"> Назад </button>
                    <input type="submit" :disabled="!disableButton" v-on:click.prevent="compare" class="btn btn-success" value="Сравнить">
                    {{--v-on:click.prevent="compare"--}}
                </div>
            </form>
        </div>
    </div>
@endsection