import { Construction } from "lucide-react";

const UnderConstruction = () => {
  return (
    <div className="min-h-screen bg-background flex items-center justify-center p-4"
      style={{
        backgroundImage: `radial-gradient(ellipse at center, hsl(0 80% 15%), hsl(0 0% 5%))`,
      }}
    >
      <div className="text-center glass rounded-2xl p-10 max-w-md">
        <Construction className="w-16 h-16 text-primary mx-auto mb-4" />
        <h1 className="font-display text-2xl md:text-3xl font-bold text-foreground mb-2">
          Under Construction
        </h1>
        <p className="text-muted-foreground mb-6">
          This page is coming soon. Check back later!
        </p>
        <a
          href="/"
          className="inline-block px-6 py-2.5 rounded-lg bg-primary text-primary-foreground font-semibold hover:bg-primary/80 transition-colors"
        >
          Back to Home
        </a>
      </div>
    </div>
  );
};

export default UnderConstruction;
