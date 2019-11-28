import org.apache.jena.riot.Lang;
import org.apache.jena.riot.RDFDataMgr;
import org.apache.jena.rdf.model.Model;
import org.apache.jena.rdf.model.ModelFactory;
import org.apache.jena.rdf.model.Property;
import org.apache.jena.rdf.model.Resource;
import org.apache.jena.util.URIref;
import org.apache.jena.vocabulary.RDF;
import org.apache.jena.vocabulary.RDFS;
import org.apache.jena.vocabulary.XSD;
public class Main{
	
	public static void main(String args[]) {
		
		// Create the model and define some prefixes (for nice serialization in RDF/XML and TTL)
        Model model = ModelFactory.createDefaultModel();
        String NS = "https://en.wikipedia.org/wiki/Portal:Current_events/";
        model.setNsPrefix( "", NS );
        model.setNsPrefix( "rdf", RDF.getURI() );
        model.setNsPrefix( "xsd", XSD.getURI() );
        model.setNsPrefix( "rdfs", RDFS.getURI() );

        // Preserve the confidence level (optional).
           //Property confidence = model.createProperty( NS+"confidence" ); 

        // Define some triplets to convert.
        Object[][] triplets = {
        		{"pub","is in","Tel Aviv Israel"},
        		{"tallest Jesus statue","is in","Africa"},
        		{"one thousand houses","is in","Manilas Tondo district"},
        		{"EUUkraine Free Trade","deal officially","comes into force coinciding with Russian food embargo on Ukraine"},
        		{"couples","is in","country"},
        		{"base","is in","Pathankot Punjab three security force personnel"},
        		{"Gisela Mota Ocampo mayor","is in","Mexicos Morelos state"},
        		{"peaceful rally","is in","support of Dwight"},
        		{"Iraqi Army base Camp Speicher","now known as","Tikrit Air Academy town Tikrit north Baghdad"},
        		{"Indian Air Force base","is in","Pathankot Punjab"},
        		{"residents","prepare for","impact of severe tropical cyclone Ula"},
        		{"temperatures","reach","freezing"},
        		{"its surrounding waters","is in","Atlantic Ocean"},
        		{"attack","is in","Tehran"},
        		{"clash","is with","police"},
        		{"Saudi Arabias execution","is in","Saudi Arabia"},
        		{"Indian Air Force base","is in","Pathankot Punjab"},
        		{"Islamic State","is in","Libya attacks Libyan oil Port of sidra"},
        		{"stock indices","plummeted by","six"},
        		{"Nokia telecommunications giant","based in","Finland"},
        		{"border","is with","Myanmar"},
        		{"Sweden","similar measures on","Aresund Bridge"},
        		{"toughen","regulation of","Firearms"},
        		{"women","is in","Colognes main square"},
        		{"Casten nemra","is","elected"},
        		{"Former Peking University prodigy Li Shulei","is named","Secretary of Discipline Inspection Commission of municipality of Beijing"},
        		{"joint operation","is with","Afghan National Security Forces"},
        		{"Saudi police","is in","AlAwamiyah Eastern Province"},
        		{"Libyan oil port","leaving","seven guards dead"},
        		{"snow","is in","Sierra Nevada mountains"},
        		{"Second Artillery Corps","is reorganized into","Peoples Liberation Army Rocket Force"},
        		{"he","suspend","collective responsibility"},
        		{"highestgrossing film","is in","US"},
        		{"Free Trade Agreement","refusal of","Permission"},
        		{"North Korea","cease","further nuclear activity"},
        		{"Texas state trooper Brian Encinia","is","charged with perjury in connection with death of Sandra Bland"},
        		{"formation","is in","Vietnam Democratic Republic of Congo"},
        		{"second time","is in","week"},
        		{"rural village","is in","southern Mexico"},
        		{"triple murder","is in","relation to death of British actress Sian Blake"},
        		{"Two suspected ISIS militants three tourists","injured in","unsuccessful attack hotel city Hurghada"},
        		{"bushfire","is in","small Western Australian town of Yarloop"},
        		{"migrant gangs","is in","city"},
        		{"El Chapo","is in","Los Mochis Sinaloa"},
        		{"former Serbian paramilitary commander","is charged with","war crimes in Croatia"},
        		{"major power station","is in","eastern Libyan city of Benghazi"},
        		{"AlNusra Front AlQaedas branch","is in","Syriarun prison complex"},
        		{"Waroona bushfire","burn out of","control"},
        		{"governments headquarters","is in","Kosovos capital Pristina"},
        		{"connection","is with","murder of Blake"},
        		{"Bolivian spectator","being hit by","Mitsubishi driven by French driver Lionel Baud"},
        		{"fans","plunges into","river in Veracruz eastern Mexico"},
        		{"TransCanada Highway","forcing detour into","US"},
        		{"single US Air Force B52 longrange strategic bomber","returning to","its base in Guam"},
        		{"Poland summons German ambassador","is in","Warsaw"},
        		{"US Army officials","set at_time","August 8"},
        		{"secret October meeting","is with","JoaquAn GuzmAin published by Rolling Stone magazine yesterday"},
        		{"his predecessor Artur Mas GavarrAs","secede from","Spain"},
        		{"he","appeal","his eight year ban"},
        		{"illegal casino","is with","Islamic State of Iraq"},
        		{"money","is in","central Mosul"},
        		{"it","collapsing","market demand for commodity"},
        		{"large industrial fire burning","is in","suburb of Broadmeadows"},
        		{"family holiday","is in","Barbados"},
        		{"they","took","banned substance thymosinbeta"},
        		{"explosion","is in","Istanbuls Sultanahmet Square"}

        };

        // For each triplet, create a resource representing the sentence, as well as the subject, 
        // predicate, and object, and then add the triples to the model.
        for ( Object[] triplet : triplets )  {
            Resource statement = model.createResource();
            Resource subject = model.createResource().addProperty( RDFS.label, (String) triplet[0] );
            Property predicate = model.createProperty( NS+URIref.encode( (String) triplet[1] ));
            Resource object = model.createResource().addProperty( RDFS.label, (String) triplet[2] );

         //  statement.addLiteral( confidence, triplet[0] );
            statement.addProperty( RDF.subject, subject );
            statement.addProperty( RDF.predicate, predicate );
            statement.addProperty( RDF.object, object );
        }

        // Show the model in a few different formats.
        RDFDataMgr.write( System.out, model, Lang.TTL );
        RDFDataMgr.write( System.out, model, Lang.RDFXML );
        RDFDataMgr.write( System.out, model, Lang.NTRIPLES );
		
	}
}