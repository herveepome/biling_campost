		extensionsValides=new Array('xlsx','xls');

		function getExtension(filename)
		{
			var parts = filename.split(".");
			return (parts[(parts.length-1)]);
		}

		// vérifie l'extension d'un fichier uploadé
		// champ : id du champ type file
		// listeExt : liste des extensions autorisées
		function verifFileExtension(champ,listeExt)
		{
			filename = document.getElementById(champ).value.toLowerCase();
			fileExt = getExtension(filename);
			for (i=0; i<listeExt.length; i++)
			{
				if ( fileExt == listeExt[i] )
				{
					return (true);
				}
			}
			alert("format de fichier doit \352tre au format Excel (.xlsx ou xls)");
			return (false);
		}
