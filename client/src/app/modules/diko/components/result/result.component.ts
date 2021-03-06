import * as $ from 'jquery';

import { Component, OnInit, QueryList, ViewChildren } from '@angular/core';
import { SearchService } from '../../services/search.service';
import { RaffinementService } from '../../services/raffinement.service';
import { LoadingService, Loading } from '../../services/loading.service';

@Component({
  selector: 'app-result',
  templateUrl: './result.component.html',
  styleUrls: ['./result.component.css']
})

export class ResultComponent implements OnInit
{
	public static readonly raffs_listener_name: string = "raff_loading_listener";

	public data: any = null;

	public relation_type_selected: any = null;

	public pos_name: string;
	public pos: string[] = null;

	public definition_page_size: number = 5;
	public definition_page_current : number = 1;

	public raffs: any = null;
	public raffs_keys: any = null;
	public raffs_is_loading: boolean = false;
	public raffs_page_size: number = 3;
	public raffs_current_page: number = 1;

	@ViewChildren('relation_types_view') relation_types_view: QueryList<any>;

	constructor(
		public loading_service: LoadingService,
		public search_service : SearchService,
		public raffinement_service: RaffinementService
	) {

	}

	ngOnInit()
	{
		function raff_callback(data: any)
		{
			if (data.length === 0)
			{
				return;
			}
			
			this.raffs = data;
			this.raffs_keys = Object.keys(this.raffs);

			for (var e in this.raffs)
			{
				var o = this.raffs[e];

				if (o.length > 0)
				{
					continue;
				}

				o.push("Il n'y a pas de définition pour ce raffinement sémantique.");
			}
		}

		function search_callback()
		{
			this.data = this.search_service.getData();
			this.relation_types_view.changes.subscribe(this.showFirstRelationType.bind(this));

			var data_raffs = {
				term: this.data.name
			};

			this.raffinement_service.request(data_raffs, raff_callback.bind(this), ResultComponent.raffs_listener_name);

			var r_pos = this.search_service.findRelationTypeByName("r_pos");

			if (r_pos !== null)
			{
				this.pos = [];
				this.pos_name = r_pos.gpname;

				var keys = {
					mas: "masculin",
					fem: "féminin",
					sg: "singulier",
					pl: "pluriel"
				};

				for (var e of r_pos.relations_out.data)
				{
					var temp_e = e.name.split(":");

					if (temp_e[0] === "Nom")
					{
						if (temp_e.length === 2 && temp_e[1].length > 0)
						{
							for (var se of temp_e[1].split("+"))
							{
								var temp_lse = se.toLowerCase();
								var temp_se = (keys[temp_lse]) ? keys[temp_lse] : se
								this.pos.push(temp_se);
							}
						}
						else
						{
							this.pos.push(temp_e[0]);
						}
					}
					else
					{
						this.pos.push(e.name);
					}
				}
			}
		}

		function loading_raff()
		{
			this.raffs_is_loading = true;
		}

		function stop_loading_raff()
		{
			this.raffs_is_loading = false;
		}

		var loading_listener: Loading.Listener = new LoadingService.Listener(loading_raff.bind(this), stop_loading_raff.bind(this));
		this.loading_service.addListener(ResultComponent.raffs_listener_name, loading_listener);

		this.search_service.run(search_callback.bind(this));
	}

	public showFirstRelationType(): void
	{
		if (this.relation_type_selected !== null || this.data.relation_types.length === 0)
		{
			return;
		}

		this.showRelations(this.data.relation_types[0], false);
	}
	
	public showRelations(relation_type: any, is_scroll: boolean = true): void
	{
		if (this.relation_type_selected !== null)
		{
			var old_button = $("#button_rt_" + this.relation_type_selected.id);
			var old_content = $("#content_rt_" + this.relation_type_selected.id);

			old_button.addClass('btn-primary');
			old_button.removeClass('btn-outline-primary');
			old_content.addClass('d-none');
		}

		this.relation_type_selected = relation_type;

		var new_button = $("#button_rt_" + this.relation_type_selected.id);
		var new_content = $("#content_rt_" + this.relation_type_selected.id);

		new_button.removeClass('btn-primary');
		new_button.addClass('btn-outline-primary');
		new_content.removeClass('d-none');

		if (is_scroll)
		{
			$("html, body").prop('scrollTop', new_content.offset().top);
		}
	}

	public scrollDefinitions(): void
	{
		var current_scroll = $("html, body").prop('scrollTop');
		var def_offset = $('#accordion-definition').offset().top;
		
		if (current_scroll < def_offset)
		{
			return;
		}
		
		$("html, body").prop('scrollTop', def_offset);
	}

	public filterRelationType(name: string): boolean
	{
		var bl = [
			"r_raff_sem",
			"r_pos"
		];

		return (!bl.includes(name));
	}

	public isArray(e: any): boolean {
		return Array.isArray(e);
	}
}
