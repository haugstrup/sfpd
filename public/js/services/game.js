'use strict';

angular
  .module('gameService', ['ngResource'])
    .factory('Games', function($resource) {
      return $resource('http://localhost:8000/api/games/:game_id', {game_id:'@game_id'}, {
        update: {
          method: 'PUT',
          transformRequest: function(data) {
            return JSON.stringify({
              status: data.status,
              results: data.results.map(function(result) {
                return {
                  player_id: result.player_id,
                  position: result.position,
                  result_id: result.result_id
                };
              })
            });
          }
        }
      });
    });
