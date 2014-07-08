'use strict';

angular
  .module('groupService', ['ngResource'])
    .factory('Groups', function($resource) {
      return $resource('/api/groups/:code', {code:'@code'}, {
        update: {
          method: 'PUT',
          transformRequest: function(data) {
            return JSON.stringify({
              players: data.players.map(function(player) {
                return {player_id: player.player_id};
              })
            });
          }
        }
      });
    });
