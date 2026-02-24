import { Button } from "@/components/ui/button";
import { Gamepad2, MessageSquare, Users } from "lucide-react";

const features = [
  {
    icon: Gamepad2,
    title: "Original Games",
    description: "Coin flip, dice, roulette, mines, and more exclusive games.",
  },
  {
    icon: MessageSquare,
    title: "Live Chat",
    description: "Chat with other players in real-time while you play.",
  },
  {
    icon: Users,
    title: "Play with Friends",
    description: "Invite friends, create groups, and compete together.",
  },
];

const FeaturesSection = () => {
  return (
    <section className="py-20 bg-background">
      <div className="container mx-auto px-4">
        <div className="text-center mb-14">
          <h2 className="font-display text-3xl md:text-4xl font-bold text-foreground mb-3">
            Why Bullseye?
          </h2>
          <p className="text-muted-foreground max-w-lg mx-auto">
            Everything you need for the ultimate prediction and gaming experience.
          </p>
        </div>

        <div className="grid md:grid-cols-3 gap-6 mb-14">
          {features.map((f) => (
            <div key={f.title} className="p-6 rounded-xl glass glass-hover text-center">
              <div className="w-14 h-14 rounded-xl bg-primary/10 flex items-center justify-center mx-auto mb-4">
                <f.icon className="w-7 h-7 text-primary" />
              </div>
              <h3 className="text-foreground font-semibold text-lg mb-2">{f.title}</h3>
              <p className="text-muted-foreground text-sm leading-relaxed">{f.description}</p>
            </div>
          ))}
        </div>

        {/* CTA */}
        <div className="text-center glass rounded-2xl p-10 box-glow">
          <h3 className="font-display text-2xl md:text-3xl font-bold text-foreground mb-3">
            Ready to hit the mark?
          </h3>
          <p className="text-muted-foreground mb-6 max-w-md mx-auto">
            Join thousands of players making predictions and winning rewards every day.
          </p>
          <Button size="lg" className="bg-primary text-primary-foreground hover:bg-primary/90 px-8 py-6 text-lg font-semibold">
            Join Bullseye Now
          </Button>
        </div>
      </div>
    </section>
  );
};

export default FeaturesSection;
